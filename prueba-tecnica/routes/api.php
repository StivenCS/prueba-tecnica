<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('user/create', 'UserController@store');
Route::put('user/{id}', 'UserController@update');
Route::delete('user/{id}', 'UserController@delete');
Route::get('user/{id}', 'UserController@get');
Route::get('users', 'UserController@all');
Route::get('categories', 'CategoryController@get');
Route::get('countries', 'UserController@getCountries');


Route::get('categories', 'CategoryController@getCategories');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
