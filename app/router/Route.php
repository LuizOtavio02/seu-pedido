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

    public function currentRota()
    {
        return $_SERVER['REQUEST_URI'] !== '/dev/seu-pedido/public/' ? 
        rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '/dev/seu-pedido/public/';
    }

    public function currentRequest()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function match()
    {
        // if para verificar se tem essa option no array
        if ($this->routeOptions->optionsExist('prefix')) {
            // essa option é para que todas as uri(rota) possuem esse prefixo passado pelo array de option
            $this->rota = rtrim("{$this->rota}{$this->routeOptions->execute('prefix')}",'/');
        }

        if ($this->routeOptions->optionsExist('controller')) {
            $this->controller = "{$this->routeOptions->execute('controller')}{$this->controller}";
        }

        if ($this->rota == $this->currentRota() && strtolower($this->request) == $this->currentRequest()) {
            return $this;
        }

    }
}




?>