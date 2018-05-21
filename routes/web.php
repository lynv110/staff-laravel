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

    Route::get('update-password', 'UpdatePasswordController@getForm')->name('_update_password');
    Route::post('update-password', 'UpdatePasswordController@change');

    Route::get('logout', 'LoginController@doLogout')->name('_logout');

    Route::get('forgot-password', 'ForgotController@getForgotForm');
    Route::post('forgot-password', 'ForgotController@forgot');

    Route::get('change-password/{token}', 'ForgotController@getChangeForm');
    Route::post('change-password/{token}', 'ForgotController@change');
});

// Logged
Route::middleware('staff_logged')->group(function (){
    // Common
    Route::namespace('Common')->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('_dashboard');
        Route::post('upload-file', 'UploadController@upload');

        // Profile
        Route::get('profile', 'ProfileController@info');
        Route::get('profile/edit', 'ProfileController@getForm');
        Route::post('profile/edit', 'ProfileController@edit');
    });

    // Not root account
    // Staff
    Route::namespace('Staff')->group(function () {
        Route::get('staff-list', 'PublicController@index');
        Route::any('staff-export', 'PublicController@export');
        Route::get('staff/info/{id}', 'StaffController@info');
    });

    Route::middleware('staff_logged_root')->group(function (){
        // Staff manager
        Route::namespace('Staff')->group(function(){
            // Part
            Route::get('part', 'PartController@index');

            Route::get('part/add', 'PartController@getForm');
            Route::post('part/add', 'PartController@add');

            Route::get('part/edit/{id}', 'PartController@getForm');
            Route::post('part/edit/{id}', 'PartController@edit');

            Route::any('part/delete', 'PartController@delete');

            // Position
            Route::get('position', 'PositionController@index');

            Route::get('position/add', 'PositionController@getForm');
            Route::post('position/add', 'PositionController@add');

            Route::get('position/edit/{id}', 'PositionController@getForm');
            Route::post('position/edit/{id}', 'PositionController@edit');

            Route::any('position/delete', 'PositionController@delete');

            // Staff
            Route::get('staff', 'StaffController@index');

            Route::get('staff/add', 'StaffController@getForm');
            Route::post('staff/add', 'StaffController@add');

            Route::get('staff/edit/{id}', 'StaffController@getForm');
            Route::post('staff/edit/{id}', 'StaffController@edit');

            Route::any('staff/delete', 'StaffController@delete');

            Route::any('staff/reset-password/{id?}', 'StaffController@resetPassword');

            Route::any('staff/export', 'StaffController@export');
        });
    });
});