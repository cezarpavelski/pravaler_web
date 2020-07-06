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

$router->group([ 'prefix' => 'v1'], function () use ($router) {
    $router->get('institutions', 'InstitutionController@index');
    $router->get('institutions/{id}', 'InstitutionController@show');
    $router->post('institutions', 'InstitutionController@store');
    $router->put('institutions/{id}', 'InstitutionController@update');
    $router->delete('institutions/{id}', 'InstitutionController@destroy');

    $router->get('courses', 'CourseController@index');
    $router->get('courses/{id}', 'CourseController@show');
    $router->post('courses', 'CourseController@store');
    $router->put('courses/{id}', 'CourseController@update');
    $router->delete('courses/{id}', 'CourseController@destroy');

    $router->get('students', 'StudentController@index');
    $router->get('students/{id}', 'StudentController@show');
    $router->post('students', 'StudentController@store');
    $router->put('students/{id}', 'StudentController@update');
    $router->delete('students/{id}', 'StudentController@destroy');
});
