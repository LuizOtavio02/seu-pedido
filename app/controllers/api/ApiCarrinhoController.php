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
}
