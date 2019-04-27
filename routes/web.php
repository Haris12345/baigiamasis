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
    return view('welcome');
});
Auth::routes(['register' => false]);

Route::get('/pagrindinis-pusl', 'HomeController@index')->name('home');
Route::get('/keisti-slaptazodi','HomeController@showChangePasswordForm')->name('password');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

// overview
Route::GET('/atsiskaitymai', 'OverviewController@index')->name('overview');

//debts
Route::GET('/skolos', 'DebtsController@index')->name('debts');