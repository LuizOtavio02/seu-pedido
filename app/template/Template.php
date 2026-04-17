<?php 
namespace app\template;

class Template
{
    public function loader()
    {
        return new \Twig\Loader\FilesystemLoader([dirname(__DIR__,2) . '/app/views/admin',
            dirname(__DIR__,2) . '/app/views/site', dirname(__DIR__,2) . '/app/views']);
    }

    public function init()
    {
        return new \Twig\Environment($this->loader(),[
            'debug' => true,
            'auto_reload' => true
        ]);
    }
}


?>