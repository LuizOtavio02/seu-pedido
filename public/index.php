<?php

use app\router\Router;
use app\router\Routes;

require '../vendor/autoload.php';

session_start();

$routes = new Routes;
$routes->addRoute('get', '/','HomeController@index');
$routes->addRoute('get', '/admin/[0-9]+','AdminController@index');
$routes->addRoute('get', '/contact','ContactController@index');
$routes->addRoute('post', '/','HomeController@index');
$routes->addRoute('post', '/a','PostHomeController@index');
$routes->addRoute('post', '/[0-9]+','PostController@index');
$routes->addRoute('put', '/','HomeController@index');
$routes->addRoute('delete', '/','HomeController@index');

$router = new Router($routes);
$router->init();

?>