<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Services\CurrencyApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class TransferController extends Controller
{
    private CurrencyApiService $currencyApiService;

    public function __construct()
    {
        $this->currencyApiService = new CurrencyApiService();
    }
    public function index()
    {
        return view('transactions.transfer');
    }

    public function transfer(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'from_account' => 'required',
            'to_account' => 'required',
            'amount' => 'required|numeric|min:1',
            '2fa_code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $fromAccountId = $request->input('from_account');
        $toAccountNumber = $request->input('to_account');
        $amount = $request->input('amount');
        $otpSecret = $request->input('2fa_code');
        $description = $request->input('description');

        $google2fa = new Google2FA();
        $secret = $user->otp_secret;

        $valid = $google2fa->verifyKey($secret, $otpSecret);

        if (!$valid) {
            Session::flash('error', 'Invalid 2FA Code');

            return redirect()->back()->withInput();
        }

        $fromAccount = BankAccount::where('owner_id', $user->id)
            ->where('id', $fromAccountId)
            ->first();

        $toAccount = BankAccount::where('account_number', $toAccountNumber)->first();

        if (!$fromAccount) {
            Session::flash('error', 'Invalid source account!');

            return redirect()->back()->withInput();
        }

        if (!$toAccount) {
            Session::flash('error', 'You have entered an invalid account number or this account does not exist!');

            return redirect()->back()->withInput();
        }

        $fromCurrency = $this->currencyApiService->getAccountCurrency($fromAccount);
        $toCurrency = $this->currencyApiService->getAccountCurrency($toAccount);

        $fromToEurRate = $this->currencyApiService->fetchConversionRate($fromCurrency, 'EUR');
        $eurToToRate = $this->currencyApiService->fetchConversionRate('EUR', $toCurrency);

        if ($fromCurrency == $toCurrency) {
            $fromToEurRate = 1;
            $eurToToRate = 1;
        }

        if ($toCurrency == 'EUR') {
            $eurToToRate = 1;
        }

        if ($fromCurrency !== 'EUR') {
            $amountInEUR = $amount / $fromToEurRate;
        } else {
            $amountInEUR = $amount;
        }

        $convertedAmount = $amountInEUR * $eurToToRate;

        Transaction::create([
            'user_id' => $user->id,
            'from_account_id' => $fromAccount->account_number,
            'to_account_id' => $toAccount->account_number,
            'type' => 'Transfer',
            'amount' => $amount,
            'description' => $description,

        ]);

        if ($fromAccount && $toAccount) {
            if ($fromAccount->balance >= $amount) {
                $fromAccount->balance -= $amount;
                $toAccount->balance += $convertedAmount;
                $fromAccount->save();
                $toAccount->save();

                Session::flash('success', 'Successfully transferred ' . number_format($convertedAmount, 2) . ' ' . $toCurrency);

                return redirect()->route('transactions');
            } else {

                Session::flash('error', 'Transaction failed! Insufficient balance!');

                return redirect()->back()->withInput();
            }
        }

        Session::flash('error', 'Invalid account details');

        return redirect()->back()->withInput();
    }
}
