<?php

namespace Repositories;

use Modeles\Profil;
use Services\Database;

class ProfilRepository
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
            'SELECT * FROM profil 
            WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ;
    }

    public function update(Profil $profil): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE profil
             SET name = :name, description = :description, email = :email, phone = :phone, github = :github, cv = :cv, id_picture = :id_picture
             WHERE id = :id'
        );
        $stmt->bindValue(":name", $profil->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":description", $profil->getDescription(), \PDO::PARAM_STR);
        $stmt->bindValue(":email", $profil->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(":phone", $profil->getPhone(), \PDO::PARAM_STR);
        $stmt->bindValue(":github", $profil->getGithub(), \PDO::PARAM_STR);
        $stmt->bindValue(":cv", $profil->getCv(), \PDO::PARAM_STR);
        $stmt->bindValue(":id_picture", $profil->getIdPicture(), \PDO::PARAM_INT);
        $stmt->bindValue(":id", $profil->getId(), \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM profil 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

}
