<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/personas/signUp', 'PersonaController@signUp');

$router->post('/personas/signIn', 'PersonaController@signIn');

$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('/personas/perfil', 'PersonaController@perfil');

    $router->post('/personas/editarPerfil', 'PersonaController@editarPerfil');
});