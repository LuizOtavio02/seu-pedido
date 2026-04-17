<?php

namespace app\helpers\session;

class Session
{
    public function sessaoExiste()
    {
        return (isset($_SESSION['funcionario'])) ? true : false;
    }

    public function criarSessao($data)
    {
        if (!$this->sessaoExiste()) {
            $_SESSION['funcionario'] = $data;
        }
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
}
