<?php

use App\Http\Controllers\Bank\BankAccountController;
use App\Http\Controllers\Bank\SecurityController;
use App\Http\Controllers\Crypto\CryptoController;
use App\Http\Controllers\Crypto\CryptoTransactionController;
use App\Http\Controllers\Crypto\PortfolioController;
use App\Http\Controllers\Transactions\DepositController;
use App\Http\Controllers\Transactions\TransactionController;
use App\Http\Controllers\Transactions\TransferController;
use App\Http\Controllers\Transactions\WithdrawController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/accounts', [BankAccountController::class, 'index'])
    ->middleware(['auth'])->name('accounts');

Route::get('/security', [SecurityController::class, 'index'])
    ->middleware(['auth'])->name('security');

// Create Account

Route::get('/create', [BankAccountController::class, 'showCreateForm'])
    ->middleware(['auth'])->name('createAccount');

Route::post('/create', [BankAccountController::class, 'create'])
    ->middleware(['auth'])->name('create');

// Deposit

Route::get('/deposit', [DepositController::class, 'index'])
    ->middleware(['auth'])->name('deposit');

Route::post('/deposit', [DepositController::class, 'deposit'])
    ->middleware(['auth'])->name('deposit');

// Withdraw

Route::get('/withdraw', [WithdrawController::class, 'index'])
    ->middleware(['auth'])->name('withdraw');
Route::post('/withdraw', [WithdrawController::class, 'withdraw'])
    ->middleware(['auth'])->name('withdraw');

// Transfer

Route::get('/transfer', [TransferController::class, 'index'])
    ->middleware(['auth'])->name('transfer');

Route::post('/transfer', [TransferController::class, 'transfer'])
    ->middleware(['auth'])->name('transfer');

// Delete Account

Route::delete('/delete/{accountNumber}', [BankAccountController::class, 'delete'])
    ->middleware(['auth'])->name('delete');

// Transactions

Route::get('/transactions', [TransactionController::class, 'index'])
    ->middleware(['auth'])->name('transactions');

Route::get('/crypto-transactions', [CryptoTransactionController::class, 'index'])
    ->middleware(['auth'])->name('cryptoTransactions');

// Crypto

Route::get('/crypto', [CryptoController::class, 'index'])
    ->middleware(['auth'])->name('crypto');

Route::get('/coin/{id}', [CryptoController::class, 'showSingleCoin'])
    ->middleware(['auth'])->name('singleCoin');

// Buy/Sell Crypto

Route::post('/coin/{id}/{symbol}/{price}/buy', [CryptoController::class, 'buyCrypto'])
    ->middleware(['auth'])->name('buyCrypto');

Route::post('/coin/{id}/{symbol}/{price}/sell', [CryptoController::class, 'sellCrypto'])
    ->middleware(['auth'])->name('sellCrypto');

// Portfolio

Route::get('/portfolio', [PortfolioController::class, 'index'])
    ->middleware(['auth'])->name('portfolio');


require __DIR__ . '/auth.php';
