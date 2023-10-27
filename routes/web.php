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

// TODO: Put these in API routes
Route::group(['middleware' => 'auth'], function () {
    Route::resource('clients', 'ClientController')->only(['index', 'create', 'store', 'show', 'destroy'])->names('clients');

    Route::group(['prefix' => 'clients'], function () {
        Route::resource('{client}/journal', 'JournalController')->only(['store', 'destroy']);
    });
});