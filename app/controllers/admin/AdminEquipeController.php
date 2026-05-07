<?php 
namespace app\controllers\admin;

use app\controllers\BaseController;

class AdminEquipeController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Equipe'
        ];

        $template = $this->twig->Load('equipe.html');

        $template->display($dados);
    }
}




?>