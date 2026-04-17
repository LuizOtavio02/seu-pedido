<?php

use app\router\Router;
use app\router\Routes;

require '../vendor/autoload.php';

session_start();

$routes = new Routes;
$routes->addRoute('get', '/','HomeController@index');
$routes->addRoute('get', '/login','LoginController@index');
$routes->addRoute('post', '/api/login','ApiAuthController@login');

$router = new Router($routes);
$router->init();

?>