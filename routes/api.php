<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {

    Route::controller(ClientController::class)->prefix('client')->group(function () {

        Route::get('list', 'index');
        Route::post('create', 'store');
        Route::put('edit/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');

    });

    Route::controller(InvoiceController::class)->prefix('invoice')->group(function () {

        Route::get('list', 'index');
        Route::post('create', 'store');
        Route::put('edit/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');

    });

});