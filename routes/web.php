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
    return view('auth.login');
});

Route::post('/data-login', 'LoginController@login');
Route::post('/data-register', 'LoginController@register');

Auth::routes(['register' => false]);

Route::match(['get', 'post', 'put', 'delete'],'/home', 'HomeController@index');
