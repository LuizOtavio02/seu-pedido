<?php

namespace app\helpers\session;

class Session
{
    public function sessaoExiste()
    {
        return (isset($_SESSION['funcionario'])) ? true : false;
    }

    public function criarSessao(array $data)
    {
        $_SESSION['funcionario'] = $data;
    }

    public function sessao()
    {
        return $_SESSION['funcionario'];
    }

    public function sessaoAuth()
    {
        if (!$this->sessaoExiste()) {
            header('Location: /login');
            exit;
        }
    }

    public function authAdmin()
    {
        return ($_SESSION['funcionario']['tipo'] == 'admin') ? true : false;
    }
}
