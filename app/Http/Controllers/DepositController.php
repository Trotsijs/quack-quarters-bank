<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class DepositController extends Controller
{
    public function index()
    {
        return view('transactions.deposit');
    }

    public function deposit(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            '2fa_code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $accountId = $request->input('account');
        $amount = $request->input('amount');
        $otpSecret = $request->input('2fa_code');
        $description = $request->input('description');

        $google2fa = new Google2FA();
        $secret = $user->otp_secret;

        $valid = $google2fa->verifyKey($secret, $otpSecret);

        if (!$valid) {
            return redirect()->back()->withErrors(['error' => 'Invalid 2FA Code'])->withInput();
        }

        $account = BankAccount::where('owner_id', $user->id)->where('id', $accountId)->first();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'from_account_id' => $account->account_number,
            'to_account_id' => '',
            'type' => 'Deposit',
            'amount' => $amount,
            'description' => $description,

        ]);

        if ($account) {
            $account->balance += $amount;
            $account->save();

            return redirect()->route('transactions')->with('success', 'Deposit successful');
        }

        return redirect()->back()->with('error', 'Account not found');
    }
}
