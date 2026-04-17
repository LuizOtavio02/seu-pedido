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
            ];

            $this->session->criarSessao($data);
            return true;
        }else {
            return false;
        }
    }

    public function cadastrar()
    {
        
    }
}




?>