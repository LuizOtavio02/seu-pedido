<?php 
namespace app\model\database;

use PDO;

class Connection
{
    public static function connect()
    {
        return new PDO('mysql:host=localhost;dbname=seupedido;charset=utf8mb4', 'root', '', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}





?>