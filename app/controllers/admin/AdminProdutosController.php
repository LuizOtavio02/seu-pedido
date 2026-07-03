<?php 
namespace app\controllers\admin;

use app\controllers\BaseController;

class AdminProdutosController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Produtos'
        ];

        $template = $this->twig->Load('adminProdutos.html');

        $template->display($dados);
    }
}



?>