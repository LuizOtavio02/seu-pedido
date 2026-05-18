<?php 
namespace app\controllers\site;

use app\controllers\BaseController;

class CompraController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Compra'
        ];

        $template = $this->twig->Load('finalizar-compra.html');

        $template->display($dados);
    }
}

?>