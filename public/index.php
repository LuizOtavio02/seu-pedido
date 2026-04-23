<?php

use app\router\Router;
use app\router\Routes;

require '../vendor/autoload.php';

session_start();

$routes = new Routes;
// GET
$routes->addRoute('get', '/','HomeController@index');
$routes->addRoute('get', '/login','LoginController@index');
$routes->addRoute('get', '/produtos','ProdutosController@index');
$routes->addRoute('get', '/cliente','ClienteController@index');
$routes->addRoute('get', '/carrinho','CarrinhoController@index');
$routes->addRoute('get', '/admin','AdminController@index');
// API GET
$routes->addRoute('get', '/api/sessao','ApiAuthController@logado');

// API POST
$routes->addRoute('post', '/api/login','ApiAuthController@login');
$routes->addRoute('post', '/api/cadastro','ApiAuthController@cadastro');
$routes->addRoute('post', '/api/cliente','ApiClienteController@create');

$router = new Router($routes);
$router->init();

?>