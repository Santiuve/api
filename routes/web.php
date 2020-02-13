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

Route::get('/', function () {
    return '<h1>Hola Mundo</h1>';
});
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/pruebas/{nombre?}', function ($nombre = null) {
    $texto = '<h2>Texto desde una ruta</h2>';
    $texto.= 'Nombre: '.$nombre;
    return view('pruebas', array(
        'texto' => $texto
    ));
});
Route::get('/animales', 'PruebasController@index');
Route::get('/test-orm', 'PruebasController@testOrm');
Route::get('/usuario/pruebas', 'UserController@pruebas');
Route::get('/categoria/pruebas', 'CategoryController@pruebas');
Route::get('/entrada/pruebas', 'PostController@pruebas');
Route::post('/api/register', 'UserController@register');
Route::post('/api/login', 'UserController@login');
Route::post('/api/user/update', 'UserController@update');