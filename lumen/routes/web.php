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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('users',  ['uses' => 'UserController@getAll']);
$router->get('user/{id}',  ['uses' => 'UserController@get']);
$router->post('user', ['uses' => 'UserController@create']);
$router->post('transaction', ['uses' => 'TransactionController@transaction']);