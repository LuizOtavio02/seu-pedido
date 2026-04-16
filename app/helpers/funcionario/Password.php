<?php 
namespace app\helpers\funcionario;


class Password
{
    public function hash($password)
    {
        $options = [
            'cost' => 11
        ];
        return password_hash($password, PASSWORD_DEFAULT, $options);
    }

    public function verificarPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}




?>