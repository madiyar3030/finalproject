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

Route::get('/', 'AdminController@Index')->name('Index');
Route::get('/managers', 'AdminController@Managers')->name('Managers');
Route::get('/employees', 'AdminController@Employees')->name('Employees');
Route::get('/departments', 'AdminController@Departments')->name('Departments');
Route::get('/history/{id}', 'AdminController@History')->name('History');
Route::get('/Info/{id}', 'AdminController@Info')->name('Info');
