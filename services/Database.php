<?php

namespace Services;

class Database
{
    private string $host = "";
    private string $dbname = "";
    private string $username = "";
    private string $password = "";
    private ?\PDO $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );

            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection(): \PDO
    {
        return $this->pdo;
    }
}