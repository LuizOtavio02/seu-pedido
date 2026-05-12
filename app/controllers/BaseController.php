<?php 
namespace app\controllers;

use Twig\Environment;

class BaseController
{
    protected Environment $twig;

    public function setTwig(Environment $twig)
    {
        $this->twig = $twig;
    }
}




?>