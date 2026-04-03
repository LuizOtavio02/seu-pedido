<?php

use app\router\Router;
use app\router\Routes;

require '../vendor/autoload.php';

session_start();

$routes = new Routes;
$routes->addRoute('get', '/','HomeController@index');
$routes->addRoute('get', '/admin/[0-9]+','AdminController@index');

$router = new Router($routes);
$router->init();

?>