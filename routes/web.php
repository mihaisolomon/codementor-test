<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
*/

$router->post("access-token", ["uses" => "Auth\AuthController@login"]);
$router->post("access-token/refresh", ["uses" => "Auth\AuthController@refresh"]);
$router->post("register", ["uses" => "Auth\RegisterController@register"]);

$router->get('/me', [
    'middleware' => 'jwt.auth.custom',
    'uses' => 'ProfileController@me'
]);

$router->get('/ideas', [
    'middleware' => 'jwt.auth.custom',
    'uses' => 'IdeasController@index'
]);
$router->post('/ideas', [
    'middleware' => 'jwt.auth.custom',
    'uses' => 'IdeasController@store'
]);
$router->put('/ideas/{idea_id}', [
    'middleware' => 'jwt.auth.custom',
    'uses' => 'IdeasController@update'
]);
$router->delete('/ideas/{idea_id}', [
    'middleware' => 'jwt.auth.custom',
    'uses' => 'IdeasController@destroy'
]);
