<?php

namespace App\Http\Controllers;

use App\Services\CryptoApiService;
use Illuminate\Http\Request;

class CryptoController extends Controller
{
    public function index()
    {
        return view('crypto');
    }

    public function show()
    {
        $cryptoApiService = new CryptoApiService();
        $coins = $cryptoApiService->getReport();
//        var_dump($coins);die;
        return view('crypto', [
            'coins' => $coins,
        ]);


    }
}
