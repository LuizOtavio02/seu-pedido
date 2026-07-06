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

    public function listarProdutos(): void
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

    public function cadastrarProduto(): void
    {
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        if (!$input || empty($input['produto']) || empty($input['preco']) || empty($input['slug']) || empty($input['estoque']) || empty($input['categoriaId'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Preencha todos os campos'
            ], JSON_PRETTY_PRINT);
            return;
        }

        $data = [
            'nome' => $input['produto'],
            'preco' => $input['preco'],
            'produto_slug' => $input['slug'],
            'estoque' => $input['estoque'],
            'categoria_id' => $input['categoriaId']
        ];

        $query = $this->produto->create($data);

        if ($query) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Produto Cadastrado com sucesso',
                'query' => $query
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível fazer o cadastro'
        ], JSON_PRETTY_PRINT);
    }
}
