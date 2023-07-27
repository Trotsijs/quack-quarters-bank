<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Session;
use App\Services\CurrencyApiService;


class BankAccountController extends Controller
{
    private CurrencyApiService $client;

    public function __construct()
    {
        $this->client = new CurrencyApiService();
    }
    public function index(): View
    {
        $user = Auth::user();
        $accounts = $user->accounts;
        $savingsAccounts = [];
        $checkingAccounts = [];

        foreach ($accounts as $account) {
            if ($account->account_type === 'savings') {
                $savingsAccounts[] = $account;
            } elseif ($account->account_type === 'checking') {
                $checkingAccounts[] = $account;
            }
        }

        return view('accounts.accounts', compact('savingsAccounts', 'checkingAccounts'));
    }


    public function showCreateForm(): View
    {
        $currencies = $this->client->getData();
        return view('accounts.createAccount', compact('currencies'));
    }

    public function create(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'required',
            '2fa_code' => 'required|numeric|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $accountType = $request->input('account_type');
        $accountNumber =
            ($accountType === 'savings') ? $this->createSavingsAccountNumber() : $this->createAccountNumber();

        $google2fa = new Google2FA();
        $secret = $user->otp_secret;
        $otpSecret = $request->input('2fa_code');

        $valid = $google2fa->verifyKey($secret, $otpSecret);

        if (!$valid) {
            Session::flash('error', 'Invalid 2FA Code!');
            return redirect()->back()->withInput();
        }

        BankAccount::create([
            'owner_id' => $user->id,
            'account_type' => $request->input('account_type'),
            'account_number' => $accountNumber,
            'balance' => 0,
            'currency' => $request->input('currency'),
        ]);

        Session::flash('success', 'Account created successfully!');

        return redirect()->route('accounts');
    }

    public function delete($accountNumber): RedirectResponse
    {
        $user = Auth::user();

        $validator = Validator::make(['account_number' => $accountNumber], [
            'account_number' => 'required|exists:bank_accounts,account_number,owner_id,' . $user->id,
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'Invalid account number');
            return redirect()->back();
        }

        $account = BankAccount::where('account_number', $accountNumber)->first();

        if ($account->balance > 0) {
            Session::flash('error', 'Cannot delete account with a balance greater than 0');
            return redirect()->back();
        }

        $account->delete();

        Session::flash('success', 'Account deleted successfully!');

        return redirect()->route('accounts');
    }


    private function createAccountNumber(): string
    {
        $accountNumber = 'LV07QUACK0000' . rand(100000000, 999999999);
        $validator = Validator::make(['account_number' => $accountNumber], [
            'account_number' => 'unique:bank_accounts,account_number',
        ]);

        if ($validator->fails()) {
            return $this->createAccountNumber();
        }

        return $accountNumber;
    }

    private function createSavingsAccountNumber(): string
    {
        $savingsAccountNumber = 'LV07QSAVE0000' . rand(100000000, 999999999);
        $validator = Validator::make(['account_number' => $savingsAccountNumber], [
            'account_number' => 'unique:bank_accounts,account_number',
        ]);

        if ($validator->fails()) {
            return $this->createAccountNumber();
        }

        return $savingsAccountNumber;
    }
}
