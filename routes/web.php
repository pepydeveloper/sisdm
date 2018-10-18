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
Route::get('/editar/{id}','DemandaController@editar');
Route::get('/exportar','DemandaController@exportar');

Route::get('/addTabela',array('as'=>'addTabela','uses'=>'AjaxController@addTabela'));
Route::get('/searchajax',array('as'=>'searchajax','uses'=>'AjaxController@autoComplete'));
Route::get('/atualizaTabelas',array('as'=>'atualizaTabelas','uses'=>'AjaxController@atualizaTabelas'));
Route::get('/verificaDemanda',array('as'=>'verificaDemanda','uses'=>'AjaxController@verificaDemanda'));
Route::get('/verificaFuncionalidade',array('as'=>'verificaFuncionalidade','uses'=>'AjaxController@verificaFuncionalidade'));
Route::get('/autoCompleteFuncionalidade',array('as'=>'autoCompleteFuncionalidade','uses'=>'AjaxController@autoCompleteFuncionalidade'));
Route::get('/autoCompleteOwner',array('as'=>'autoCompleteOwner','uses'=>'AjaxController@autoCompleteOwner'));
Route::get('/autoCompleteTabela',array('as'=>'autoCompleteTabela','uses'=>'AjaxController@autoCompleteTabela'));
