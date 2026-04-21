<?php 
namespace app\controllers\api;

use app\helpers\classes\Filter;
use app\helpers\funcionario\FuncionarioSession;

class ApiAuthController
{
    private $funcionario;
    private $filter;
    

    public function __construct() {
        $this->funcionario = new FuncionarioSession;
        $this->filter = new Filter;
    }

    public function logado()
    {
        $retorno = $this->funcionario->logado();

        header('Content-Type: application/json');

        if ($retorno) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'sessao' => $retorno
            ],JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível verificar se esta logado'
        ],JSON_PRETTY_PRINT);
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

        
        $username = $this->filter->filter('string',$input['username']);
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
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        if (!$input || empty($input['nome']) || empty($input['username']) || empty($input['senha']) || empty($input['tipo']) ) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível realizar o cadastro Algum campo esta vazio'
            ],JSON_PRETTY_PRINT);
            return;
        }

        $data = [
            'nome' => $this->filter->filter('string', $input['nome']),
            'username' => $this->filter->filter('string', $input['username']),
            'senha' => $input['senha'],
            'tipo' => $this->filter->filter('string', $input['tipo'])
        ];

        $cadastro = $this->funcionario->cadastrar($data);

        if ($cadastro) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Login feito com sucesso',
                'data' => $cadastro
            ],JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível realizar o cadastro'
        ],JSON_PRETTY_PRINT);
    }
}



?>