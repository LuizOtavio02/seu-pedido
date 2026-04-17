<?php 
namespace app\controllers\api;

use app\helpers\classes\Filter;
use app\helpers\funcionario\FuncionarioSession;

class ApiAuthController
{
    private $funcionario;

    public function __construct() {
        $this->funcionario = new FuncionarioSession;
    }

    public function logado()
    {
        
    }

    public function login()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        
        header('Content-Type: application/json');

        if (!$input || empty($input['username']) || empty($input['senha'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível realizar o login Algum campo esta vazio'
            ],JSON_PRETTY_PRINT);
            return;
        }

        $filter = new Filter;
        $username = $filter->filter('string',$input['username']);
        $logar = $this->funcionario->login($username,$input['senha']);

        if ($logar) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Login feito com sucesso'
            ],JSON_PRETTY_PRINT);
            return;
        }
        
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível realizar o login'
        ],JSON_PRETTY_PRINT);
    }

    public function cadastro()
    {
        
    }
}



?>