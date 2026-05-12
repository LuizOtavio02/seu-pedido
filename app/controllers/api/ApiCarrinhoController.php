<?php

namespace app\controllers\api;

use app\helpers\carrinho\Carrinho;
use app\helpers\carrinho\StatusCarrinho;
use app\model\site\ProdutoModel;

class ApiCarrinhoController
{
    private Carrinho $carrinho;
    private StatusCarrinho $statusCarrinho;
    private ProdutoModel $produtoModel;

    public function __construct()
    {
        $this->carrinho = new Carrinho;
        $this->statusCarrinho = new StatusCarrinho;
        $this->produtoModel = new ProdutoModel;
    }

    public function index()
    {
        $carrinho = $this->statusCarrinho->carrinho();

        header('Content-Type: application/json');

        $produtos = [];
        $valorCarrinho = 0;

        if (empty($carrinho)) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Carrinho Vazio',
                'produtos' => $produtos
            ], JSON_PRETTY_PRINT);
            return;
        }

        foreach ($carrinho as $id => $qtd) {
            $produtoCarrinho = $this->produtoModel->find('id', $id);
            $valor = $produtoCarrinho['preco'];

            $valorCarrinho += $valor * $qtd;

            $produtos[] = [
                'produtos' => $produtoCarrinho,
                'valorTotal' => $valor * $qtd,
                'quantidade' => $qtd,
                'valor' => $valor
            ];
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'produtos' => $produtos,
            'total' => [
                'qtdTotal' => $qtd,
                'valorCarrinho' => $valorCarrinho
            ]

        ], JSON_PRETTY_PRINT);
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
    }

    public function update()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        if (!$input) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível atualizar o carrinho'
            ], JSON_PRETTY_PRINT);
            return;
        }

        $this->carrinho->update($input['id'], $input['qtd']);

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Carrinho Atualizado',
        ], JSON_PRETTY_PRINT);
    }

    public function delete()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        if (!$input) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Não foi possível deletar do carrinho'
            ], JSON_PRETTY_PRINT);
            return;
        }

        $this->carrinho->delete($input['id']);

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Carrinho Atualizado',
        ], JSON_PRETTY_PRINT);
    }

    public function addCliente()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        
        header('Content-Type: application/json');

        $this->carrinho->addCliente($input['cliente_id']);

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Cliente Adicionado ao carrinho',
        ], JSON_PRETTY_PRINT);
    }
}
