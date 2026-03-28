<?php


use app\router\Router;

require '../vendor/autoload.php';

session_start();

$router = new Router;

try {
    // Utilizo o método group para rotas especificas de um grupo como o admin
    // é passado por parâmetro um array de options e uma função callback que adiciona as rotas com o método add
    $router->group(['prefix' => 'admin', 'controller' => 'Admin'], function () {
        $this->add('/dev/seu-pedido/public/', 'GET', 'HomeController:index');
        $this->add('/product/(:numeric)', 'GET', 'ProductController:index');
    });

    // Utilizo o método add para adicionar rotas ao projeto
    // é passado por parâmetro a rota, o tipo de requisição e o seu controller
    $router->add('/dev/seu-pedido/public/', 'GET', 'HomeController:index');
    $router->add('/product/(:numeric)', 'GET', 'ProductController:index');



    // Após add as rotas eu utilizo o método init para iniciar o processo das rotas
    $router->init();
} catch (\Throwable $e) {
    dd($e->getMessage());
}
