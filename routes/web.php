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

Route::get('/', function () {return view('welcome');});
Route::get('/login','JwtControllers@sendtoken')->name('sendtoken');
Route::post('/login','JwtControllers@login')->name('login');
Route::get('/logout','JwtControllers@logout')->name('logout');
Route::post('/decodetoken','JwtControllers@decodetoken')->name('decodetoken');