<?php

namespace App\Http\Controllers;

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

}
