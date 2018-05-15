<?php

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
    if (!Staff::isLogged()) {
        return redirect(route('_login'));
    } else {
        return redirect(route('_dashboard'));
    }
});

// Auth verified
Route::namespace('Common')->group(function () {
    Route::get('login', 'LoginController@getForm')->name('_login');
    Route::post('login', 'LoginController@doLogin');

    Route::get('logout', 'LoginController@doLogout')->name('_logout');
});

// Logged
Route::middleware('staff_logged')->group(function (){
    // Common
    Route::namespace('Common')->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('_dashboard');
    });

});