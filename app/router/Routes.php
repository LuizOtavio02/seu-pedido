<?php 
namespace app\router;

class Routes
{
    private array $routes = [];

    public function addRoute($request, $uri, $controller) : void
    {   
        $this->routes[$request][$uri] = $controller;
    }

    public function getRoutes() : array
    {
        return $this->routes;
    }
}




?>