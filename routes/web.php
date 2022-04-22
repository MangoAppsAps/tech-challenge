<?php

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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('clients', 'ClientsController')->except(['edit', 'update']);
    Route::delete('bookings/{booking}','BookingController@destroy');

    Route::group(['prefix' => 'clients'], function () {
        Route::post('/bookings/filter', 'ClientsController@filterBookings');

        Route::get('{client}/create/journal', 'JournalController@create');
        Route::post('/{client}/journal', 'JournalController@store');
        Route::delete('journal/{journal}', 'JournalController@destroy');

    });

});
