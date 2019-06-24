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

$router->get('/', function () use ($router) {
  return $router->app->version();
});
$router->post('/login','AuthController@authenticate');

$router->group(['middleware'=>'auth'],function () use ($router){
    $router->get('cars','CarController@getAll');
    $router->post('car','CarController@create');
    $router->get('car/{id}','CarController@show');

    //
    $router->get('users','UserController@getAll');
    $router->post('user','UserController@create');
    $router->get('user/{id}','UserController@show');
    $router->put('user/{id}','UserController@update');
    $router->delete('user/{id}','UserController@delete');
});



$router->get('/key', function() {
  return str_random(32);
});
