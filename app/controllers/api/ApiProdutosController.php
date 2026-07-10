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

    public function update(array $id): void
    {
        $produto = $id[0];

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível Atualizar o Produto'
            ], JSON_PRETTY_PRINT);
            return;
        }

        $update = $this->produto->update($produto,$input);

        if (!$update) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível Atualizar o Produto'
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Produto Atualizado com sucesso'
        ], JSON_PRETTY_PRINT);
    }

    public function busca(array $id): void
    {
        $busca = $id[0];

        $funcionario = $this->produto->find('id', $busca);

        header('Content-Type: application/json');

        if ($funcionario) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $funcionario
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível achar o usuario',
            'a' => $busca
        ], JSON_PRETTY_PRINT);
    }

    public function autocomplete(array $nome): void
    {
        $busca = $nome[0];

        $resultado = $this->produto->findLike('nome', $busca);

        header('Content-Type: application/json');

        if ($resultado) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $resultado
            ], JSON_PRETTY_PRINT);
            return;
        }

        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível encontrar um resultado',
        ], JSON_PRETTY_PRINT);
    }
}
