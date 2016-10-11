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

Route::get('/produtos', 'ProdutoController@index');
Route::post('/produto', 'ProdutoController@store');
Route::delete('/produto/{produto}', 'ProdutoController@destroy');

Route::get('/', 'HomeController@index');
