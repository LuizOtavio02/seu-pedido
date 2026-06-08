<?php 
namespace app\controllers\site;

use app\controllers\BaseController;

class PagamentoController extends BaseController
{
    public function success()
    {
        $dados = [
            'titulo' => 'Success'
        ];

        $template = $this->twig->Load('PagamentoSuccess.html');

        $template->display($dados);
    }

    public function pending()
    {
        $dados = [
            'titulo' => 'Pending'
        ];

        $template = $this->twig->Load('PagamentoPending.html');

        $template->display($dados);
    }
    
    public function failure()
    {
        $dados = [
            'titulo' => 'Failure'
        ];

        $template = $this->twig->Load('PagamentoFailure.html');

        $template->display($dados);
    }
}




?>