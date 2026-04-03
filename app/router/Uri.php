<?php 
namespace app\router;

class Uri
{
    public function currentUri() : string
    {
        return ($_SERVER['REQUEST_URI']) !== '/' ? 
        rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : 
        '/';
    }

    public function request() : string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);   
    }
}




?>