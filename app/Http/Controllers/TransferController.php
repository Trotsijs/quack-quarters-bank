<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class TransferController extends Controller
{
    public function index()
    {
        return view('transfer');
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

        $google2fa = new Google2FA();
        $secret = $user->otp_secret;

        $valid = $google2fa->verifyKey($secret, $otpSecret);

        if (!$valid) {
            return redirect()->back()->withErrors(['error' => 'Invalid 2FA Code'])->withInput();
        }

        $fromAccount = BankAccount::where('owner_id', $user->id)
            ->where('id', $fromAccountId)
            ->first();

        $toAccount = BankAccount::where('account_number', $toAccountNumber)->first();

        $transaction = Transaction::create([
            'from_account_id' => $fromAccountId,
            'to_account_id' => $toAccountNumber,
            'type' => 'Transfer',
            'amount' => $amount,
            'description' => 'Transfer',

        ]);

        if ($fromAccount && $toAccount) {
            if ($fromAccount->balance >= $amount) {
                $fromAccount->balance -= $amount;
                $toAccount->balance += $amount;
                $fromAccount->save();
                $toAccount->save();

                return redirect()->back()->with('success', 'Transfer successful!');
            } else {
                return redirect()->back()->withErrors
                (
                    [
                        'error' => 'Transaction failed! Insufficient balance!',
                    ]
                )->withInput();
            }
        }

        return redirect()->back()->withErrors(['error' => 'Invalid account details'])->withInput();
    }
}
