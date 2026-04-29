<?php 
namespace app\controllers\api;

use app\model\site\ProdutoModel;

class ApiProdutosController
{
    private ProdutoModel $produto;

    public function __construct() {
        $this->produto = new ProdutoModel;
    }
    
    public function listarProdutos()
    {
        $produtos = $this->produto->fetchAll();

        header('Content-Type: application/json');

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'produtos' => $produtos
        ],JSON_PRETTY_PRINT);
    }
}




?>