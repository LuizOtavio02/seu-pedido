<?php

namespace app\controllers\api;

use app\model\site\ProdutoModel;

class ApiProdutosController
{
    private ProdutoModel $produto;

    public function __construct()
    {
        $this->produto = new ProdutoModel;
    }

    public function listarProdutos() : void
    {
        $produtos = $this->produto->fetchAll();

        header('Content-Type: application/json');

        if ($produtos) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'produtos' => $produtos
            ], JSON_PRETTY_PRINT);
            return;
        }
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível listar os produtos'
        ], JSON_PRETTY_PRINT);
    }

    public function cadastrarProduto() : void
    {
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => $input
        ], JSON_PRETTY_PRINT);
    }
}
