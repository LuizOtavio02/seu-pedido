<?php 
namespace app\controllers;

use Exception;

class Controller
{
    private const CONTROLLERS_FOLDER = ['admin', 'api', 'site'];
    private const NAMESPACE_CONTROLLER = "\\app\\controllers\\";
    private const ERROR_CONTROLLER = "\\app\\controllers\\error\\";
    
    public function call($route, $twig, $param = []) : void
    {
        if ($route === 'ErrorController@index') {
            [$controller, $method] = explode('@',$route);
            $controllerNamespace = self::ERROR_CONTROLLER.$controller;
            $controller = new $controllerNamespace;
            $controller->$method();
        }

        if (!str_contains($route,'@')) {
            throw new Exception("Rota não possuí @");
        }

        [$controller, $method] = explode('@',$route);

        foreach (self::CONTROLLERS_FOLDER as $folders) {
            if (class_exists(self::NAMESPACE_CONTROLLER.$folders."\\".$controller)) {
                $controllerNamespace = self::NAMESPACE_CONTROLLER.$folders."\\".$controller;
                break; 
            }
        }

        if (!isset($controllerNamespace)) {
            throw new Exception("O Controller {$controller} não Existe");
        }

        $controller = new $controllerNamespace;

        if (!str_contains($controllerNamespace,'Api')) {
            $controller->setTwig($twig);
        }

        if (!method_exists($controller,$method)) {
            throw new Exception("O Método {$method} não existe");
        }

        $controller->$method($param);
    }
}




?>