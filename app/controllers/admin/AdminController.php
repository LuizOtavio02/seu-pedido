<?php 
namespace app\controllers\admin;

use app\controllers\BaseController;
use app\helpers\session\Session;

class AdminController extends BaseController
{
    public function index()
    {
        $auth = new Session;
        
        $path = 'admin-site.html';

        if ($auth->authAdmin()) {
            $path = 'admin.html';
        }

        $dados = [
            'titulo' => 'Admin'
        ];

        $template = $this->twig->Load($path);

        $template->display($dados);
    }
}




?>