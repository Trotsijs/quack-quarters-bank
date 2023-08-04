<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->latest()
            ->orWhere('to_user_id', $user->id)->latest()
            ->get();

        return view('transactions.transactions', compact('transactions'));
    }
}
