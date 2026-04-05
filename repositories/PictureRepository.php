<?php

namespace Repositories;

use Modeles\Picture;
use Services\Database;

class PictureRepository
{
    private \PDO $pdo;

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
    }

    public function getById(int $id): array|bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM picture 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ;
    }

    public function getByProject(int $idProject): array|bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM picture 
            WHERE id_project = :id_project'
        );
        $stmt->bindParam(":id_project", $idProject, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function create(Picture $picture): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO picture (link, id_project) 
            VALUES (:link, :id_project)'
        );
        $stmt->bindValue(":link", $picture->getLink(), \PDO::PARAM_STR);
        $stmt->bindValue(":id_project", $picture->getIdProject(), \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;

    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM picture 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

}
