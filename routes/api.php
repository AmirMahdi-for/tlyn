<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['fake-auth', ])->group(function () {

    Route::prefix('orders')->group(function () {
        
        Route::post('store', [OrderController::class, 'store']);
        Route::get('/{id}', [OrderController::class, 'get']);
        Route::get('/', [OrderController::class, 'list']);
        Route::post('/{id}/cancel', [OrderController::class, 'cancel']); 

    });

    Route::prefix('transactions')->group(function () {
        
        Route::get('/{id}', [TransactionController::class, 'get']);
        Route::get('/', [TransactionController::class, 'list']);

    });

    Route::prefix('user/wallet')->group(function () {
        
        Route::get('', [UserController::class, 'getWalletBalance']);
        Route::post('/withdraw', [UserController::class, 'withdrawFromWallet']);
        Route::post('/deposit', [UserController::class, 'depositToWallet']);

    });
    
});
