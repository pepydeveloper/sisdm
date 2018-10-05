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
Route::get('/addtabela',array('as'=>'addtabela','uses'=>'AjaxController@addtabela'));
Route::get('/searchajax',array('as'=>'searchajax','uses'=>'AjaxController@autoComplete'));
Route::get('/atualizaTabelas',array('as'=>'atualizaTabelas','uses'=>'AjaxController@atualizaTabelas'));
Route::get('/verificademanda',array('as'=>'verificademanda','uses'=>'AjaxController@verificademanda'));
Route::get('/autocompletefuncionalidade',array('as'=>'autocompletefuncionalidade','uses'=>'AjaxController@autocompletefuncionalidade'));
Route::get('/autocompleteowner',array('as'=>'autocompleteowner','uses'=>'AjaxController@autocompleteowner'));
Route::get('/autocompletetabela',array('as'=>'autocompletetabela','uses'=>'AjaxController@autocompletetabela'));
