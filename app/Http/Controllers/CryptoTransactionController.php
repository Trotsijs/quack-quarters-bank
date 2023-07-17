<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\CryptoTransaction;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CryptoTransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cryptoTransactions = CryptoTransaction::where('user_id', $user->id)->get();
        return view('cryptoTransactions', compact('cryptoTransactions'));
    }

}
