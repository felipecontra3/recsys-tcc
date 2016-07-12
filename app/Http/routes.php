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

Route::get('/', 'MainController@index');
Route::get('/save-facebook', 'MainController@saveFacebook');
Route::get('/logoff-facebook', 'MainController@logoffFacebook');
Route::get('/save-twitter', 'MainController@saveTwitter');
Route::get('/obter-dados-sociais', 'MainController@obterDadosSociais');

