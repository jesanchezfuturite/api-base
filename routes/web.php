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

//login api
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');
    // Matches "/api/login
    $router->post('login', 'AuthController@login');

    $router->get('users',  ['uses' => 'UsersController@showAllUsers']);
  
    /*
    $router->get('authors/{id}', ['uses' => 'AuthorController@showOneAuthor']);
    $router->post('authors', ['uses' => 'AuthorController@create']);
    $router->delete('authors/{id}', ['uses' => 'AuthorController@delete']);
    $router->put('authors/{id}', ['uses' => 'AuthorController@update']);
    */

});

//organizaciones
$router->group(['prefix' => 'organizations'], function () use ($router) {
    // Matches "/api/register   
    $router->get('get/{id}', ['uses' => 'OrganizationController@getOne']);
    $router->get('all', ['uses' => 'OrganizationController@getAll']);
    $router->post('new', ['uses' => 'OrganizationController@create']);
    $router->delete('delete/{id}', ['uses' => 'OrganizationController@delete']);
    $router->put('update', ['uses' => 'OrganizationController@update']);
    
});

//perfiles
$router->group(['prefix' => 'profiles'], function () use ($router) {
    // Matches "/api/register   
    $router->get('get/{id}', ['uses' => 'ProfilesController@getOne']);
    $router->get('all', ['uses' => 'ProfilesController@getAll']);
    $router->post('new', ['uses' => 'ProfilesController@create']);
    $router->delete('delete/{id}', ['uses' => 'ProfilesController@delete']);
    $router->put('update', ['uses' => 'ProfilesController@update']); 
});

//herramientas
$router->group(['prefix' => 'tools'], function () use ($router) {
    // Matches "/api/register   
    $router->get('get/{id}', ['uses' => 'ToolsController@getOne']);
    $router->get('all', ['uses' => 'ToolsController@getAll']);
    $router->post('new', ['uses' => 'ToolsController@create']);
    $router->delete('delete/{id}', ['uses' => 'ToolsController@delete']);
    $router->put('update', ['uses' => 'ToolsController@update']); 
});


