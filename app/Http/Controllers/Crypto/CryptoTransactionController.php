<?php

namespace App\Http\Controllers\Crypto;

use App\Http\Controllers\Controller;
use App\Models\CryptoTransaction;
use Illuminate\Support\Facades\Auth;

class CryptoTransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cryptoTransactions = CryptoTransaction::where('user_id', $user->id)->get();
        return view('crypto.cryptoTransactions', compact('cryptoTransactions'));
    }

}
