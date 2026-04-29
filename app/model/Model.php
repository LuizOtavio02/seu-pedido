<?php 
namespace app\model;

use app\model\database\Connection;
use PDO;

class Model
{
    protected ?PDO $pdo = null;
    protected string $table;

    public function __construct() {
        $this->pdo = Connection::connect();
    }

    public function fetchAll()
    {
        $query = "select * from {$this->table}";
        $prepare = $this->pdo->prepare($query);
        $prepare->execute();

        return $prepare->fetchAll();
    }

    public function find(string $field, string $value)
    {
        $query = "select * from {$this->table} where {$field} = :{$field}";
        $prepare = $this->pdo->prepare($query);
        $prepare->execute([
            "{$field}" => $value
        ]);

        return $prepare->fetch();
    }

    public function create(array $data)
    {
        $fields = array_keys($data);
        $columns = implode(', ',$fields);
        $placeholder = implode(', :',$fields);

        $query = "insert into {$this->table} ({$columns}) values (:{$placeholder})";
        $prepare = $this->pdo->prepare($query);
        $prepare->execute($data);

        return $this->pdo->lastInsertId();
    }

}





?>