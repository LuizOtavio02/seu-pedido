<?php 
namespace app\controllers\api;

use app\helpers\carrinho\Carrinho;

class ApiCarrinhoController
{
    private Carrinho $carrinho;

    public function __construct() {
        $this->carrinho = new Carrinho;
    }

    public function add()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        if (!is_numeric($input['id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível adicionar ao carrinho'
            ], JSON_PRETTY_PRINT);
            return;
        }

        $this->carrinho->add($input['id']);

        http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Adicionado ao carrinho',
                'carrinho' => $_SESSION['carrinho']
            ], JSON_PRETTY_PRINT);
            return;
    }
}




?>