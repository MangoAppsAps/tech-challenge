<?php

use App\Http\Controllers\ClientController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', function(Request $request) {
        return new UserResource($request->user());
    });

    Route::post('clients/create_journal', [ClientController::class, 'createJournal']);
    Route::delete('clients/delete_journal/{journal}', [ClientController::class, 'deleteJournal']);
    Route::delete('clients/delete_booking/{booking}', [ClientController::class, 'deleteBooking']);
    Route::apiResource('clients', ClientController::class);
});
