<?php 
namespace app\controllers\site;

use app\controllers\BaseController;
use app\helpers\session\Session;

class HomeController extends BaseController
{
    public function index()
    {
        $auth = new Session;
        $auth->sessaoAuth();
        
        $dados = [
            'titulo' => 'Home'
        ];

        $template = $this->twig->Load('home.html');

        $template->display($dados);
    }
}




?>