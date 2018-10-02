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

Route::get('/', 'DemandaController@index');
Route::get('/cadastrar','DemandaController@cadastrar');
Route::post('/add','DemandaController@add');

//Route::group(['prefix' => 'demanda'], function(){
//    Route::get('/','DemandaController@index');
//    Route::get('/cadastrar','DemandaController@cadastrar');
//});
