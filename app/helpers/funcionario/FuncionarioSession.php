<?php 
namespace app\helpers\funcionario;

use app\model\site\FuncionarioModel;

class FuncionarioSession
{
    public $funcionario;
    public $password;

    public function __construct() {
        $this->funcionario = new FuncionarioModel;
        $this->password = new Password;
    }

    public function login($username, $senha)
    {
        $funcionario = $this->funcionario->find('username',$username);

        if (!$funcionario) {
            return false;
        }

        $data = [];

        if ($funcionario['senha'] == $senha) {
            $data = [
            'id' => $funcionario['id'],
            'nome' => $funcionario['nome'],
            'username' => $funcionario['username'],
            'senha' => $funcionario['senha']
            ];
        }
        

        return $data;
    }

    public function cadastrar()
    {
        
    }
}




?>