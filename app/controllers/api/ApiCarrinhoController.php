<?php

namespace app\controllers\api;

use app\helpers\carrinho\Carrinho;
use app\helpers\carrinho\StatusCarrinho;
use app\helpers\cliente\Cliente;
use app\model\site\ClienteModel;
use app\model\site\EnderecoModel;
use app\model\site\ProdutoModel;

class ApiCarrinhoController
{
    private Carrinho $carrinho;
    private StatusCarrinho $statusCarrinho;
    private ProdutoModel $produtoModel;
    private Cliente $cliente;
    private ClienteModel $clienteModel;
    private EnderecoModel $endereco;

    public function __construct()
    {
        $this->carrinho = new Carrinho;
        $this->statusCarrinho = new StatusCarrinho;
        $this->produtoModel = new ProdutoModel;
        $this->cliente = new Cliente;
        $this->clienteModel = new ClienteModel;
        $this->endereco = new EnderecoModel;
    }

    public function index() : void
    {
        $carrinho = $this->statusCarrinho->carrinho();

        header('Content-Type: application/json');

        if (!$carrinho) {
            http_response_code(200);
            echo json_encode([
                'success' => false,
                'message' => 'Carrinho não Existe',
            ], JSON_PRETTY_PRINT);
            return;
        }

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

        $cliente = null;

        if ($this->cliente->clienteExiste()) {
            $cliente = $this->cliente->cliente();
            $dadosCliente = $this->clienteModel->find('id', $cliente);
            $enderecoCliente = $this->endereco->find('cliente_id', $cliente);

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'cliente' => [
                    'dados' => $dadosCliente,
                    'endereco' => $enderecoCliente
                ],
                'produtos' => $produtos,
                'total' => [
                    'qtdTotal' => $qtd,
                    'valorCarrinho' => $valorCarrinho
                ]
            ], JSON_PRETTY_PRINT);
        }

        http_response_code(200);
            echo json_encode([
                'success' => true,
                'cliente' => [],
                'produtos' => $produtos,
                'total' => [
                    'qtdTotal' => $qtd,
                    'valorCarrinho' => $valorCarrinho
                ]
            ], JSON_PRETTY_PRINT);

        
    }

    public function add() : void
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

    public function update() : void
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

    public function delete() : void
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

    public function addCliente() : void
    {
        $input = json_decode(file_get_contents("php://input"), true);

        header('Content-Type: application/json');

        $this->cliente->addCliente($input['cliente_id']);

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Cliente Adicionado ao carrinho',
        ], JSON_PRETTY_PRINT);
    }
}
