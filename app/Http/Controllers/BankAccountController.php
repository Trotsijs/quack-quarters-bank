<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;


class BankAccountController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $accounts = $user->accounts;

        if ($accounts) {
            $accounts = $accounts->all();
        } else {
            $accounts = [];
        }

        return view('accounts', compact('accounts'));
    }


    public function showCreateForm(): View
    {
        return view('createAccount');
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
        $accountNumber = $this->createAccountNumber();

        $google2fa = new Google2FA();
        $secret = $user->otp_secret;
        $otpSecret = $request->input('2fa_code');

        $valid = $google2fa->verifyKey($secret, $otpSecret);

        if (!$valid) {
            return redirect()->back()->withErrors(['error' => 'Invalid 2FA Code'])->withInput();
        }

        BankAccount::create([
            'owner_id' => $user->id,
            'account_number' => $accountNumber,
            'balance' => 0,
            'currency' => $request->input('currency'),
        ]);

        return redirect()->route('accounts')->with('success', 'Account created successfully!');
    }

    public function delete($accountNumber): RedirectResponse
    {
        $user = Auth::user();

        $validator = Validator::make(['account_number' => $accountNumber], [
            'account_number' => 'required|exists:bank_accounts,account_number,owner_id,' . $user->id
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['error' => 'Invalid account number']);
        }

        $account = BankAccount::where('account_number', $accountNumber)->first();

        if ($account->balance > 0) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete account with a balance greater than 0']);
        }

        $account->delete();

        return redirect()->route('accounts')->with('success', 'Account deleted successfully!');
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
}
