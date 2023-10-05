<?php

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Client\ClientsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Journal\JournalsController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'clients'], function () {
    Route::as('clients.')->group(function () {
        Route::get('/', [ClientsController::class, 'index'])->name('index');
        Route::view('/create', 'clients.create')->name('create');
        Route::post('/', [ClientsController::class, 'store'])->name('store');
        Route::get('/{client}', [ClientsController::class, 'show'])->name('show');
        Route::delete('/{client}', [ClientsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/{client}/journals')->as('journals.')->group(function () {
        Route::get('/', [JournalsController::class, 'index'])->name('index');
        Route::post('/', [JournalsController::class, 'store'])->name('store');
        Route::delete('/{journal}', [JournalsController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('/{client}/bookings')->as('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    });
});
