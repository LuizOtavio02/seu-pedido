<?php 
namespace app\controllers\site;

use app\controllers\BaseController;

class ProdutosController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Produtos'
        ];

        $template = $this->twig->Load('produtos.html');

        $template->display($dados);
    }
}




?>