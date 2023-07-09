<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\SecurityController;
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

Route::get('/security', [SecurityController::class, 'index'])->name('security');

require __DIR__.'/auth.php';
