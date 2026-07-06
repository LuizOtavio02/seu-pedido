<?php

namespace app\model;

use app\model\Transactions;
use PDO;

class Model
{
    protected ?PDO $pdo = null;
    protected string $table;

    public function __construct()
    {
        $this->pdo = Transactions::get();
    }

    public function fetchAll()
    {
        $query = "select * from {$this->table}";
        $prepare = $this->pdo->prepare($query);
        if ($prepare->execute()) {
            return $prepare->fetchAll();
        }
        return false;
    }

    public function find(string $field, string $value)
    {
        $query = "select * from {$this->table} where {$field} = :{$field}";
        $prepare = $this->pdo->prepare($query);
        if ($prepare->execute([$field => $value])) {
            return $prepare->fetch();
        }

        return false;
    }

    public function create(array $data)
    {
        $fields = array_keys($data);
        $columns = implode(', ', $fields);
        $placeholder = implode(', :', $fields);

        $query = "insert into {$this->table} ({$columns}) values (:{$placeholder})";
        $prepare = $this->pdo->prepare($query);
        if ($prepare->execute($data)) {
            return $this->pdo->lastInsertId();
        }

        return false;
    }

    public function findLike(string $field, string $value)
    {
        $query = "SELECT * FROM {$this->table}
              WHERE {$field} LIKE :{$field}
              LIMIT 10";

        $prepare = $this->pdo->prepare($query);

        $prepare->execute([
            $field => "%{$value}%"
        ]);

        $dados = $prepare->fetchAll(PDO::FETCH_ASSOC);

        return !empty($dados) ? $dados : false;
    }

    // public function findLike(string $field, string $value)
    // {
    //     $query = "select * from {$this->table} where {$field} like :{$field} limit 1";
    //     $prepare = $this->pdo->prepare($query);
    //     $prepare->execute([$field => $value]);

    //     if (($prepare) and ($prepare->rowCount() != 0)) {
    //         while ($rowProduto = $prepare->fetch(PDO::FETCH_ASSOC)) {
    //             return $dados[] = [
    //                 'funcionario' => $rowProduto
    //             ];
    //         }
    //     }

    //     return false;
    // }

}
