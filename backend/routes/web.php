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
// Route::get('/hello', function () {
//     return view('top');
// });

// Route::get('/home', 'App\Http\Controllers\HomeController@top')->name('home.top');
// Route::post('/home', 'App\Http\Controllers\HomeController@test2');

// Route::get('/hello', 'App\Http\Controllers\HomeController@top')->name('hello');
Route::get('/hello/add', 'App\Http\Controllers\HomeController@add');
Route::post('/hello/result', 'App\Http\Controllers\HomeController@result');
