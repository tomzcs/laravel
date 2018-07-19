<?php

use Illuminate\Http\Request;

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
header('Access-Control-Allow-Origin : http://localhost:8100');
header('Access-Control-Allow-Credentials : true');
header('Access-Control-Allow-Methods : GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Access-Control-Allow-Headers : Origin, X-Requested-With, Content-Type, Accept, Authorization');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'API\UserController@details');
  Route::get('latlong', 'API\UserController@latlong');

});
