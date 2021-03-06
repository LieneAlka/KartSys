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



Auth::routes();


Route::get('/', 'HomeController@index')->name('home')->middleware('auth')->middleware('lang');



Route::get('karts/add', 'KartController@create')->name('kartAdd')->middleware('is-technical')->middleware('lang'); //displays form for adding karts in view "add"

Route::get('karts', 'KartController@index')->name('kartPage')->middleware('auth')->middleware('lang'); //displays all karts as a list in view "show"

Route::post('karts', 'KartController@store')->middleware('auth')->middleware('lang');

Route::get('karts/{kart_id}', 'KartController@show')->name('kart')->middleware('auth')->middleware('lang');

Route::post('karts/{kart_id}', 'CommentController@store')->name('add_comment')->middleware('is-technical')->middleware('lang');

Route::get('karts/{kart}/edit', 'KartController@edit')->name('kartEdit')->middleware('is-technical')->middleware('lang');

Route::post('karts/{kart}/edit', 'KartController@update')->name('kartPost')->middleware('is-technical')->middleware('lang');

Route::delete('karts/{kart}', 'KartController@destroy')->name('kartDel')->middleware('is-technical')->middleware('lang');

//Route::post('karts/{kart_id}', 'CommentController@store')->name('imageAdd')->middleware('is-technical')->middleware('lang');



Route::get('reservations/add', 'ReservationController@create')->name('reservAdd')->middleware('is-admin')->middleware('lang');

Route::post('reservations', 'ReservationController@store')->name('add_reserv')->middleware('is-admin')->middleware('lang');

Route::get('reservations', 'ReservationController@index')->name('reservIndex')->middleware('auth')->middleware('lang');

Route::get('reservations/today', 'ReservationController@today')->name('reservToday')->middleware('auth')->middleware('lang');

Route::get('reservations/{reservation}/edit', 'ReservationController@edit')->name('resEdit')->middleware('is-admin')->middleware('lang');

Route::post('reservations/{reservation}/edit', 'ReservationController@update')->name('resPost')->middleware('is-admin')->middleware('lang');

Route::delete('reservations/{reservation}/delete', 'ReservationController@destroy')->name('resDel')->middleware('is-admin')->middleware('lang');



Route::get('/users', 'ManagerController@index')->name('view-users')->middleware('is-manager')->middleware('lang'); 

Route::get('/users/{id}', 'ManagerController@edit')->name('edit-users')->middleware('is-manager')->middleware('lang');

Route::delete('users/deleteUser/{id}', 'ManagerController@destroy')->name('delete-users')->middleware('is-manager')->middleware('lang');


Route::get('{lang}', 'HomeController@language')->name('langRoute')->middleware('lang');


