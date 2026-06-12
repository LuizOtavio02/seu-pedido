<?php

namespace app\model;

use app\model\database\Connection;
use PDO;

class Transactions
{
    protected static ?PDO $pdo = null;

    public static function get(): PDO
    {
        self::$pdo ??= Connection::connect();

        return self::$pdo;
    }

    public static function inTransaction(): bool
    {
        return self::$pdo instanceof PDO && self::$pdo->inTransaction();
    }

    public static function open(): void
    {
        self::$pdo ??= Connection::connect();

        if (!self::$pdo->inTransaction()) {
            self::$pdo->beginTransaction();
        }
    }

    public static function close(): void
    {
        if (self::inTransaction()) {
            self::$pdo->commit();
        }
    }

    public static function rollBack(): void
    {
        if (self::inTransaction()) {
            self::$pdo->rollBack();
        }
    }
}
