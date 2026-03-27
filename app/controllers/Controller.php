<?php 
namespace app\controllers;

use app\router\Route;
use Exception;

class Controller
{
    public function call(Route $route)
    {
        $controller = $route->controller;

        if (!str_contains($controller, ':')) {
            throw new Exception("Error ':' é preciso no Controller {$controller} no route");
        }

        [$controller, $method] = explode(':', $controller);

        $controllerInstance = "app\\controllers";

        if (!class_exists($controllerInstance)) {
            throw new Exception("Error controller: {$controllerInstance} não existe");
        }

        $controller = new $controllerInstance;

        if (!method_exists($controller,$method)) {
            throw new Exception("Error o método {$method} do controller {$controllerInstance} não existe");
        }

        $controller->$method();
    }
}




?>