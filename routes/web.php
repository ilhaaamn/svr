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
    if ($user = auth()->user()){
        if ($user->is_admin)
        {
            return redirect()->route('users');
        }
    }
    return redirect()->route('display.index');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request')->middleware('is_admin');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email')->middleware('is_admin');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset')->middleware('is_admin');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->middleware('is_admin');

//Auth::routes();

//Display Route
Route::resource('display','ReportController');
Route::resource('branch','BranchController');

//Admin Route
Route::get('users','AdminController@user')->name('users')->middleware('is_admin');

Route::get('reports','AdminController@report')->name('reports')->middleware('is_admin');
Route::get('reports/detail/{id}','AdminController@detail_report')->name('reports')->middleware('is_admin');

//Admin Model Route
Route::get('models','AdminController@model')->name('models')->middleware('is_admin');
Route::get('models/add','AdminController@showInsertModel')->name('models')->middleware('is_admin');
Route::post('models/add','AdminController@InsertModel')->name('models.add')->middleware('is_admin');
Route::get('models/edit/{id}','AdminController@showUpdateModelForm')->name('models')->middleware('is_admin');
Route::post('models/edit','AdminController@UpdateModel')->name('models.update')->middleware('is_admin');

