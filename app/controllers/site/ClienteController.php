<?php 
namespace app\controllers\site;

use app\controllers\BaseController;

class ClienteController extends BaseController
{
    public function index()
    {
        $dados = [
            'titulo' => 'Cliente'
        ];

        $template = $this->twig->Load('cliente.html');

        $template->display($dados);
    }
}




?>