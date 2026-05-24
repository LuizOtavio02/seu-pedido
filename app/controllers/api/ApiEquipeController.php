<?php 
namespace app\controllers\api;

use app\model\site\FuncionarioModel;

class ApiEquipeController
{
    private FuncionarioModel $funcionarioModel;

    public function __construct() {
        $this->funcionarioModel = new FuncionarioModel;
    }
    public function busca()  : void
    {
        $busca = trim($_GET['b']) ?? '';

        $funcionario = $this->funcionarioModel->findLike('nome', $busca);

        header('Content-Type: application/json');

        if ($funcionario) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $funcionario
            ],JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível achar o usuario'
        ],JSON_PRETTY_PRINT);
    }
}







?>