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

    public function update(int $id, int $qtd)
    {
        if ($this->statusCarrinho->produtoCarrinho($id)) {
            if ($_SESSION['carrinho'][$id] == 0 && $qtd == -1) {
                return;
            }
            $_SESSION['carrinho'][$id] += $qtd;
        }

    }

    public function delete(int $id)
    {
        if ($this->statusCarrinho->produtoCarrinho($id)) {
            unset($_SESSION['carrinho'][$id]);
        }
    }

}




?>