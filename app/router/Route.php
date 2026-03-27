<?php 
namespace app\router;

class Route
{
    private ?RouteOptions $routeOptions = null;

    public function __construct(
        public $rota, 
        public $request, 
        public $controller) {
    }
    
    public function addRouteGroupOptions(RouteOptions $routeOptions)
    {
        // adiciono o array de options vindo de uma instancia da classe RouteOptions
        $this->routeOptions = $routeOptions;
    }

    public function getRouteGroupOptions()
    {
        // get para pegar o as options da rota
        return $this->routeOptions;
    }

    public function match()
    {
        // if para verificar se tem essa option no array
        if ($this->routeOptions->optionsExist('prefix')) {
            // essa option é para que todas as uri(rota) possuem esse prefixo passado pelo array de option
            $this->rota = rtrim("/{$this->routeOptions->execute('prefix')}{$this->rota}",'/');
        }

        if ($this->routeOptions->optionsExist('controller')) {
            $this->controller = "{$this->routeOptions->execute('controller')}{$this->controller}";
        }

        return $this;
    }
}




?>