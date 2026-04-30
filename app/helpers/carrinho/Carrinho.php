<?php 
namespace app\helpers\carrinho;

class Carrinho
{
    private StatusCarrinho $statusCarrinho;

    public function __construct() {
        $this->statusCarrinho = new StatusCarrinho;
        $this->statusCarrinho->criarCarrinho();
    }

    public function add(int $id)
    {
        if ($this->statusCarrinho->produtoCarrinho($id)) {
            $_SESSION['carrinho'][$id] += 1;
            return;
        }

        $_SESSION['carrinho'][$id] = 1;
    }
}




?>