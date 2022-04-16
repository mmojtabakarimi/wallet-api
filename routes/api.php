<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1'], function () {
    Route::get('/balance', [WalletController::class, 'getAll']);
    Route::get('/balance/{user_id}', [WalletController::class, 'getTotalBalanceByUserId']);
    Route::post('/balance/{user_id}', [WalletController::class, 'addBalance']);

    Route::get('/getdailybalance', [WalletController::class, 'getDailyBalance']);

});
