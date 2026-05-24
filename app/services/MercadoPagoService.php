<?php

namespace app\services;

use app\helpers\carrinho\StatusCarrinho;
use app\model\site\ProdutoModel;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    private PreferenceClient $cliente;
    private StatusCarrinho $statusCarrinho;
    private ProdutoModel $produtoModel;

    public function __construct()
    {
        $this->cliente = new PreferenceClient();
        $this->statusCarrinho = new StatusCarrinho;
        $this->produtoModel = new ProdutoModel;
        MercadoPagoConfig::setAccessToken("APP_USR-4535711344698925-052311-9b0e512d4c9e39de92fd1ac81d451704-3419041441");
    }

    public function preference()
    {
        $preference = $this->cliente->create([
            "back_urls" => [
                "success" => "https://test.com/success",
                "failure" => "https://test.com/failure",
                "pending" => "https://test.com/pending"
            ],
            "items" => $this->items(),
            "auto_return" => "all",
        ]);

        return [
            'url' => $preference->init_point
        ];
    }

    public function items()
    {
        $carrinho = $this->statusCarrinho->carrinho();

        $items = [];

        foreach ($carrinho as $id => $qtd) {
            $produtoCarrinho = $this->produtoModel->find('id', $id);

            $items[] = [
                'id' => $produtoCarrinho['id'],
                'title' =>  $produtoCarrinho['nome'],
                'category_id' => $produtoCarrinho['categoria_id'],
                'quantity' => $qtd,
                'currency_id' => 'BRL',
                'unit_price' =>  (float) $produtoCarrinho['preco']
            ];
        }

        return $items;
    }
}
