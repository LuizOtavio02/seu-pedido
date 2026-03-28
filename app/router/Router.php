<?php 
namespace app\router;

use app\controllers\Controller;
use Closure;

class Router
{
    private array $routes = [];
    private array $routeOptions = []; 

    public function add($rota, $request, $controller)
    {
      // passo para a classe Route a rota, requisição e o controller
      $route = new Route($rota,$request,$controller);

      // se for add pelo group passo o array de options se nao passa um array vazio
      $route->addRouteGroupOptions(new RouteOptions($this->routeOptions));

      // salvo no array routes instancias da classe Route com a rota, requisição e o controller e com seu array de options
      $this->routes[] = $route;
    }

    public function group(array $options, Closure $callback)
    {
      // atribuo o array de options
      $this->routeOptions = $options;

      // passo para o callback o this que é a instancia dessa própria classe para poder utilizar o método add
      $callback->call($this);

      // após o uso esvazio o array de options para que não passe options para rotas que nao precisam
      $this->routeOptions = [];
    }

    public function init()
    {
      // dando um foreach no array routes a onde o $route  vai ser a instancia de cada rota
      foreach ($this->routes as $route) {
        if ($route->match()) {
          return (new Controller)->call($route);
        }
      }
    }

}


?>