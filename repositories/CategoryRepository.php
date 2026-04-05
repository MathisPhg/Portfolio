<?php

namespace Repositories;

use LDAP\Result;
use Modeles\Category;
use Services\Database;

class CategoryRepository
{
    private \PDO $pdo;
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
    }

    public function getAll(): array|bool
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM category 
            ORDER BY name'
        );
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $categorylist = [];
        foreach ($result as &$category) {
            $categorylist[] = new Category( $category['id'], $category['name']);
        }

        return $categorylist;


    }

    public function getById(int $id): ?Category
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM category 
            WHERE id = :id'
        );
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
    
        $category = new Category($result['id'], $result['name']);
        return $category;
    }


    public function getNumber(): int 
    {
        $stmt = $this->pdo->query(
            'SELECT COUNT(*) FROM category'
        );
        $result = $stmt->fetchColumn();
        return (int)$result;
    }

    public function create(Category $category): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO category (name) 
            VALUES (:name)'
        );
        $stmt->bindValue(":name", $category->getName(), \PDO::PARAM_STR);
        $result = $stmt->execute();
        return $result;
    }

    public function update(Category $category): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE category 
            SET name = :name 
            WHERE id = :id'
        );
        $stmt->bindValue(":name", $category->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":id", $category->getId(), \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM category 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

}
