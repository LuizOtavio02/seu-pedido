<?php 
namespace app\model;

use app\model\database\Connection;
use PDO;

class Model
{
    protected ?PDO $pdo = null;
    protected $table;

    public function __construct() {
        $this->pdo = Connection::connect();
    }

    public function find($field, $value)
    {
        $query = "select * from {$this->table} where {$field} = :{$field}";
        $prepare = $this->pdo->prepare($query);
        $prepare->execute([
            "{$field}" => $value
        ]);

        return $prepare->fetch();
    }

}





?>