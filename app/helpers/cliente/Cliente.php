<?php 
namespace app\helpers\cliente;

class Cliente
{
    public function clienteExiste()
    {
        return (isset($_SESSION['cliente'])) ? true : false;
    }

    public function cliente()
    {
        return $_SESSION['cliente'];
    }

    public function addCliente(int $id)
    {
        if (isset($_SESSION['cliente'])) {
            return;
        }
        $_SESSION['cliente'] = $id;
    }
}




?>