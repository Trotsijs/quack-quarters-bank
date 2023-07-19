<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\CryptoCoin;
use App\Models\CryptoTransaction;
use App\Models\Portfolio;
use App\Services\CryptoApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;

class CryptoController extends Controller
{
    public function index()
    {
        $cryptoApiService = new CryptoApiService();
        $coins = $cryptoApiService->getReport();;


        return view('crypto', [
            'coins' => $coins,
        ]);
    }

    public function showSingleCoin($id)
    {
        $cryptoApiService = new CryptoApiService();
        $coin = $cryptoApiService->getInfoById($id);
        $coinInfo = $cryptoApiService->getCoinById($id)->quote->USD;;
        foreach ($coin->data as $coin) {
            $coin = new CryptoCoin(
                [
                    'id' => $id,
                    'name' => $coin->name,
                    'symbol' => $coin->symbol,
                    'logo' => $coin->logo,
                    'description' => $coin->description,
                    'website' => $coin->urls->website[0],

                ]
            );
        }

        return view('singleCoin', [
            'coin' => $coin,
            'coinInfo' => $coinInfo,
            'coinPrice' => $coinInfo->price,
            'coinSymbol' => $coin->symbol,
            'coinId' => $id,
        ]);
    }

    public function buyCrypto(Request $request, $coinId, $coinSymbol, $coinPrice): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.00000001',
            '2fa_code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $amount = $request->input('amount');
        $otpSecret = $request->input('2fa_code');

        $google2fa = new Google2FA();
        $secret = $user->otp_secret;

        $valid = $google2fa->verifyKey($secret, $otpSecret);

        if (!$valid) {
            return redirect()->back()->withErrors(['error' => 'Invalid 2FA Code'])->withInput();
        }

        $fromAccount = BankAccount::where('owner_id', $user->id)
            ->where('account_type', 'savings')
            ->first();


        $existingPortfolio = Portfolio::where('account_id', $fromAccount->id)
            ->where('coin_id', $coinId)
            ->first();

        if ($existingPortfolio) {
            $existingPortfolio->amount += $amount;
            $existingPortfolio->save();
        } else {
            Portfolio::create([
                'account_id' => $fromAccount->id,
                'coin_id' => $coinId,
                'coin_symbol' => $coinSymbol,
                'amount' => $amount,
                'owner_id' => $user->id,
            ]);
        }

        CryptoTransaction::create([
            'user_id' => $user->id,
            'account_id' => $fromAccount->id,
            'coin_id' => $coinId,
            'coin_symbol' => $coinSymbol,
            'coin_price' => $coinPrice,
            'coin_amount' => $amount,
            'type' => 'Buy',
            'spent' => $amount * $coinPrice,
        ]);

        $fromAccount->balance -= $amount * $coinPrice;
        $fromAccount->save();

        return redirect()->route('cryptoTransactions')->with('Transaction successful');
    }

    public function sellCrypto(Request $request, $coinId, $coinSymbol, $coinPrice): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.00000001',
            '2fa_code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $amount = $request->input('amount');
        $otpSecret = $request->input('2fa_code');


        $google2fa = new Google2FA();
        $secret = $user->otp_secret;

        $valid = $google2fa->verifyKey($secret, $otpSecret);

        if (!$valid) {
            return redirect()->back()->withErrors(['error' => 'Invalid 2FA Code'])->withInput();
        }

        $fromAccount = BankAccount::where('owner_id', $user->id)
            ->where('account_type', 'savings')
            ->first();

        $existingPortfolio = Portfolio::where('account_id', $fromAccount->id)
            ->where('coin_id', $coinId)
            ->first();

        if ($existingPortfolio) {
            if ($existingPortfolio->amount < $amount) {
                return redirect()->back()->with('error', 'Insufficient amount of ' . $coinSymbol . ' in your portfolio.');
            }
            $existingPortfolio->amount -= $amount;
            $existingPortfolio->save();
        } else {
            return redirect()->back()->with('error', 'You do not have ' . $coinSymbol . ' in your portfolio.');
        }

        CryptoTransaction::create([
            'user_id' => $user->id,
            'account_id' => $fromAccount->id,
            'coin_id' => $coinId,
            'coin_symbol' => $coinSymbol,
            'coin_price' => $coinPrice,
            'coin_amount' => $amount,
            'type' => 'Sell',
            'spent' => $amount * $coinPrice,
        ]);

        $fromAccount->balance += $amount * $coinPrice;
        $fromAccount->save();

        return redirect()
            ->route('cryptoTransactions')
            ->with('Transaction successful');
    }


}
