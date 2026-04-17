<?php 
namespace app\controllers\site;

use app\controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Login'
        ];

        $template = $this->twig->Load('login.html');

        $template->display($dados);
    }
}




?>