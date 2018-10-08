<?php

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

    // your routes here

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('test','HomeController@index');
// $router->get('facebook/redirect','HomeController@facebook_redirect');
// $router->get('facebook/login','HomeController@facebook_login');

$router->group(['prefix' => 'api/'], function ($router) {
$router->get('login/','UsersController@authenticate');
$router->post('todo/','TodoController@store');
$router->get('todo/', 'TodoController@index');
$router->get('todo/{id}/', 'TodoController@show');
$router->put('todo/{id}/', 'TodoController@update');
$router->delete('todo/{id}/', 'TodoController@destroy');
});


