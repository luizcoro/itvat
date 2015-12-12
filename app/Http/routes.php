<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('general.home');
});

Route::get('/medico-clinica-anuncio', function () {
    return view('general.medico-clinica-anuncio');
});

Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');
Route::get('/profile', 'Auth\AuthController@profile');
Route::get('/cadastrar', 'Auth\AuthController@getRegister');
Route::post('/cadastrar', 'Auth\AuthController@postRegister');


Route::get('/medicos', 'MedicoController@index');
Route::get('/medico/cadastrar', 'MedicoController@create');
Route::post('/medico/cadastrar/login', 'MedicoController@store_login');
Route::post('/medico/cadastrar/novo', 'MedicoController@store_novo');
Route::get('/medico/horarios-disponiveis/{id}', 'MedicoController@getHorariosDisponiveis');
Route::get('/medico/{id}', 'MedicoController@show');


Route::get('/agendamentos', 'AgendamentoController@index');
Route::post('/agendamento/cadastrar', 'AgendamentoController@store');

Route::get('/horarios', 'HorarioController@index');
Route::get('/areas', 'AreaController@index');


Route::get('/clinicas', 'ClinicaController@index');
Route::get('/clinica/cadastrar', 'ClinicaController@create');
Route::post('/clinica/cadastrar', 'ClinicaController@store');
Route::get('/clinica/{id}', 'ClinicaController@show');
