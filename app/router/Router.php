<?php 
namespace app\router;

use app\controllers\Controller;
use app\template\Template;

class Router
{
    private $routes;
    private $uri;

    public function __construct(Routes $routes) {
        $this->routes = $routes->getRoutes();
        $this->uri = new Uri;
    }

    private function simpleRoute() : ?string
    {
        if (array_key_exists($this->uri->currentUri(), $this->routes[$this->uri->request()])) {
            return $this->routes[$this->uri->request()][$this->uri->currentUri()];
        }

        return null;
    }

    private function dynamicRoute() : ?string
    {
        $uri = $this->uri->currentUri();

        $route = null;

        foreach ($this->routes[$this->uri->request()] as $key => $value) {
            $pattern = str_replace('/','\/',ltrim($key,'/'));
            if ($key !== '/' && preg_match("/^$pattern$/",ltrim($uri,'/'))) {
                $route = $value;
                break;
            }
        }

        return $route;
    }
    
    public function init()
    {
        $controller = new Controller;
        $template = new Template;
        $twig = $template->init();

        if ($this->simpleRoute()) {
            return $controller->call($this->simpleRoute(),$twig);
        }

        if ($this->dynamicRoute()) {
            return $controller->call($this->dynamicRoute(), $twig);
        }

        return $controller->call('ErrorController@index', $twig);
    }
}




?>