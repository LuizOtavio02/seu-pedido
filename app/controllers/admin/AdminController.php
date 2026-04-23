<?php 
namespace app\controllers\admin;

use app\controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Admin'
        ];

        $template = $this->twig->Load('admin.html');

        $template->display($dados);
    }
}




?>