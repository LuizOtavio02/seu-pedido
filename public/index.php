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
$routes->addRoute('get', '/admin/equipe','AdminEquipeController@index');
// API GET
$routes->addRoute('get', '/api/sessao','ApiAuthController@logado');
$routes->addRoute('get', '/api/produtos','ApiProdutosController@listarProdutos');
$routes->addRoute('get', '/api/carrinho','ApiCarrinhoController@index');
// API POST
$routes->addRoute('post', '/api/login','ApiAuthController@login');
$routes->addRoute('post', '/api/cadastro','ApiAuthController@cadastro');
$routes->addRoute('post', '/api/cliente','ApiClienteController@create');
$routes->addRoute('post', '/api/carrinho','ApiCarrinhoController@add');
// API PUT
$routes->addRoute('put', '/api/carrinho/[0-9]+','ApiCarrinhoController@update');
// API DELETE
$routes->addRoute('delete', '/api/carrinho/[0-9]+','ApiCarrinhoController@delete');

$router = new Router($routes);
$router->init();

?>