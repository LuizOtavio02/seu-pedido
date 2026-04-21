<?php 
namespace app\helpers\funcionario;

use app\helpers\session\Session;
use app\model\site\FuncionarioModel;

class FuncionarioSession
{
    public $funcionario;
    public $password;
    public $session;

    public function __construct() {
        $this->funcionario = new FuncionarioModel;
        $this->password = new Password;
        $this->session = new Session;
    }

    public function login($username, $senha)
    {
        $funcionario = $this->funcionario->find('username',$username);

        if (!$funcionario) {
            return false;
        }

        if ($funcionario['senha'] == $senha) {
            $data = [
                'id' => $funcionario['id'],
                'nome' => $funcionario['nome'],
                'username' => $funcionario['username'],
                'tipo' => $funcionario['tipo'],
                'logado' => true
            ];

            $this->session->criarSessao($data);
            return true;
        }else {
            return false;
        }
    }

    public function cadastrar($data)
    {
        $data['senha'] = $this->password->hash($data['senha']);

        return $this->funcionario->create($data);
    }

    public function logado()
    {
        if (isset($_SESSION['funcionario']['logado']) && $_SESSION['funcionario']['logado'] == true) {
            return $this->session->sessao();
        }

        return false;
    }
}




?>