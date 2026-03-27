<?php 
namespace app\router;

class RouteOptions
{

    public function __construct(private readonly array $options) {
        
    }

    public function optionsExist(string $index)
    {
        // verifico se a option existe no array
        return !empty($this->options) && isset($this->options[$index]);
    }

    public function execute(string $index)
    {
        // passo o resultado da option pedida
        return $this->options[$index];
    }

}





?>