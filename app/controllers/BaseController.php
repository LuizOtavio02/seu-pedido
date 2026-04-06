<?php 
namespace app\controllers;

class BaseController
{
    protected $twig;

    public function setTwig($twig)
    {
        $this->twig = $twig;
    }
}




?>