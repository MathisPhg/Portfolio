<?php

namespace Repositories;

use Modeles\User;
use Services\Database;

class UserRepository
{
    private \PDO $pdo;

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
    }

    public function getId(int $id): ?User
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM user 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return null;
        }
        $user = new User($result['id'], $result['name'], $result['password']);
        return $user;
    }

    public function getName(string $name): ?User
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM user 
            WHERE name = :name'
        );
        $stmt->bindParam(":name", $name, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return null;
        }
        $user = new User($result['id'], $result['name'], $result['password']);
        return $user;
    }

}
