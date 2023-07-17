<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\CryptoTransactionController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WithdrawController;
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

Route::get('/create', [BankAccountController::class, 'showCreateForm'])
    ->middleware(['auth'])->name('createAccount');

Route::post('/create', [BankAccountController::class, 'create'])
    ->middleware(['auth'])->name('create');

Route::get('/deposit', [DepositController::class, 'index'])
    ->middleware(['auth'])->name('deposit');
Route::post('/deposit', [DepositController::class, 'deposit'])
    ->middleware(['auth'])->name('deposit');

Route::get('/withdraw', [WithdrawController::class, 'index'])
    ->middleware(['auth'])->name('withdraw');
Route::post('/withdraw', [WithdrawController::class, 'withdraw'])
    ->middleware(['auth'])->name('withdraw');

Route::get('/transfer', [TransferController::class, 'index'])
    ->middleware(['auth'])->name('transfer');
Route::post('/transfer', [TransferController::class, 'transfer'])
    ->middleware(['auth'])->name('transfer');

Route::delete('/delete/{accountNumber}', [BankAccountController::class, 'delete'])
    ->middleware(['auth'])->name('delete');

Route::get('/transactions', [TransactionController::class, 'index'])
    ->middleware(['auth'])->name('transactions');

Route::get('/crypto', [CryptoController::class, 'index'])
    ->middleware(['auth'])->name('crypto');

Route::get('/coin/{id}', [CryptoController::class, 'showSingleCoin'])
    ->middleware(['auth'])->name('singleCoin');

Route::post('/coin/{id}/{symbol}/{price}/buy', [CryptoController::class, 'buyCrypto'])
    ->middleware(['auth'])->name('buyCrypto');

Route::post('/coin/{id}/{symbol}/{price}/sell', [CryptoController::class, 'sellCrypto'])
    ->middleware(['auth'])->name('sellCrypto');

Route::get('/crypto-transactions', [CryptoTransactionController::class, 'index'])
    ->middleware(['auth'])->name('cryptoTransactions');


Route::get('/security', [SecurityController::class, 'index'])->name('security');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');


//Route::get('/buy', [CryptoTransactionController::class, 'index'])->name('buyCrypto');
//Route::post('/buy', [CryptoTransactionController::class, 'buyCrypto'])->name('buyCrypto');





require __DIR__.'/auth.php';
