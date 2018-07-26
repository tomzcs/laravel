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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/edit_form/{id}', 'HomeController@edit_form')->name('home');
Route::post('/edit_save', 'HomeController@edit_save');
Route::post('/video', 'HomeController@video');

Route::post('/user_data', 'HomeController@datatable');
