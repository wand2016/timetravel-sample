<?php

use Illuminate\Routing\Router;

/** @var Router $router */

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


$router->get('/', function () {
    return view('welcome');
});

$router->auth();

$router->match(['get', 'post'], '/home', 'HomeController@index')->name('home');
