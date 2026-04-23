<?php 
namespace app\controllers\site;

use app\controllers\BaseController;

class CarrinhoController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Carrinho'
        ];

        $template = $this->twig->Load('carrinho.html');

        $template->display($dados);
    }
}




?>