<?php

namespace app\controllers\api;

use app\helpers\carrinho\StatusCarrinho;
use app\helpers\cliente\Cliente;
use app\helpers\session\Session;
use app\model\site\ItemPedidoModel;
use app\model\site\PedidoModel;
use app\model\site\ProdutoModel;
use app\model\Transactions;
use Exception;

class ApiPedidoController
{
    private StatusCarrinho $statusCarrinho;
    private ProdutoModel $produtoModel;
    private PedidoModel $pedidoModel;
    private ItemPedidoModel $itemPedidoModel;
    private Session $session;
    private Cliente $cliente;

    public function __construct()
    {
        $this->statusCarrinho = new StatusCarrinho;
        $this->produtoModel = new ProdutoModel;
        $this->pedidoModel = new PedidoModel;
        $this->itemPedidoModel = new ItemPedidoModel;
        $this->session = new Session;
        $this->cliente = new Cliente;
    }

    public function salvar()
    {
        $carrinho = $this->statusCarrinho->carrinho();

        header('Content-Type: application/json');

        if ($this->session->sessao() && $this->cliente->cliente() && $carrinho) {
            $data = [
                'funcionario_id' => $_SESSION['funcionario']['id'],
                'entrega_id' => '1',
                'cliente_id' => $_SESSION['cliente']
            ];

            $itemValidados = [];

            foreach ($carrinho as $id => $qtd) {
                $produtoCarrinho = $this->produtoModel->find('id', $id);

                if ($produtoCarrinho) {
                    $itemValidados[] = [
                        'produto' => $produtoCarrinho,
                        'quantidade' => $qtd
                    ];
                }
            }

            if (empty($itemValidados)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Nenhum produto válido encontrado no carrinho'
                ], JSON_PRETTY_PRINT);
                return;
            }

            try {

                Transactions::open();

                $pedidoId = $this->pedidoModel->create($data);

                if (!$pedidoId) {
                    throw new Exception("Não foi possível salvar o pedido");
                }

                foreach ($itemValidados as $item) {
                    $itemPedido = [
                        'quantidade' => $item['quantidade'],
                        'preco' => $item['produto']['preco'],
                        'produto_id' => $item['produto']['id'],
                        'pedido_id' => $pedidoId
                    ];

                    $itemId = $this->itemPedidoModel->create($itemPedido);

                    if (!$itemId) {
                        throw new Exception('Erro ao criar item do pedido');
                    }
                }

                Transactions::close();

                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Pedido Salvo com Sucesso'
                ], JSON_PRETTY_PRINT);

                return;
            } catch (Exception $e) {

                Transactions::rollBack();

                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ], JSON_PRETTY_PRINT);
                return;
            }
        }

        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Não foi possível salvar o pedido'
        ], JSON_PRETTY_PRINT);
    }
}
