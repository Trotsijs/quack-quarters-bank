<?php

namespace App\Http\Controllers;

use App\Models\CryptoCoin;
use App\Services\CryptoApiService;
use Illuminate\Http\Request;

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
        $coin = $cryptoApiService->getById($id);
        foreach ($coin->data as $coin) {
            $coin = new CryptoCoin(
                [
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
        ]);
    }
}
