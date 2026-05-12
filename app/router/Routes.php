<?php 
namespace app\router;

class Routes
{
    private array $routes = [];

    public function addRoute(string $request, string $uri, string $controller) : void
    {   
        $this->routes[$request][$uri] = $controller;
    }

    public function getRoutes() : array
    {
        return $this->routes;
    }
}




?>