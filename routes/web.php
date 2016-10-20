<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Rotas
Auth::routes();

Route::get('/maquinas', 'MaquinaController@index');
Route::post('/maquina', 'MaquinaController@store');
Route::delete('/maquina/{maquina}', 'MaquinaController@destroy');

Route::get('/fabricantes', 'FabricanteController@index');
Route::post('/fabricante', 'FabricanteController@store');
Route::delete('/fabricante/{fabricante}', 'FabricanteController@destroy');

Route::get('/marcas', 'MarcaController@index');
Route::post('/marca', 'MarcaController@store');
Route::delete('/marca/{marca}', 'MarcaController@destroy');
//
Route::get('/marcas/all', 'MarcaController@allJson');


Route::get('/produtos', 'ProdutoController@index');
Route::post('/produto', 'ProdutoController@store');
Route::delete('/produto/{produto}', 'ProdutoController@destroy');
//
Route::get('/produtos/marcas/{marca}', 'ProdutoController@porMarcaJson');


Route::get('/filials', 'FilialController@index');
Route::post('/filial', 'FilialController@store');
Route::delete('/filial/{filial}', 'FilialController@destroy');

Route::get('/unidades', 'UnidadeController@index');
Route::post('/unidade', 'UnidadeController@store');
Route::delete('/unidade/{unidade}', 'UnidadeController@destroy');

Route::get('/estoque', 'EstoqueController@entrada');
Route::post('/estoque', 'EstoqueController@store');

Route::get('/estoque/marca/{marca}', 'EstoqueController@porMarcaJson');

Route::get('/', 'HomeController@index');