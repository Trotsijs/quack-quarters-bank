<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\CryptoCoin;
use App\Models\CryptoTransaction;
use App\Models\Portfolio;
use App\Services\CryptoApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function buyCrypto(Request $request, $coinId, $coinSymbol, $coinPrice)
    {
        $user = Auth::user();
        $fromAccountId = $request->input('from_account');
        $amount = $request->input('amount');
        $otpSecret = $request->input('2fa_code');

        $fromAccount = BankAccount::where('owner_id', $user->id)
            ->where('id', $fromAccountId)
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
                'buy_price' => $coinPrice,
                'amount' => $amount,
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

        return redirect()->route('cryptoTransactions')->with('success', 'You have successfully bought ' . $amount . ' ' . $coinSymbol . ' for ' . $amount * $coinPrice . ' USD');
    }

}
