<?php

namespace Repositories;

use Modeles\Skill;
use Services\Database;

class SkillRepository
{
    private \PDO $pdo;
    
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM skill 
            ORDER BY name'
        );
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $skillList = [];
        foreach ($result as &$skill) {
            $skillList[] = new Skill($skill['id'], $skill['name'], $skill['level']);
        }
        return $skillList;
    }

    public function getById(int $id): ?Skill
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM skill 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            return null;
        }
        $skill = new Skill($result["id"], $result["name"], $result["level"]);
        return $skill;
    }

    public function getByProject(int $idProject): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.* FROM skill s
             INNER JOIN project_skill ps ON ps.id_skill = s.id
             WHERE ps.id_project = :id_project
             ORDER BY s.name'
        );
        $stmt->bindParam(":id_project", $idProject, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $skillList = [];
        foreach ($result as &$skill) {
            $skillList[] = new Skill($skill['id'], $skill['name'], $skill['level']);
        }
        return $skillList;
    
        }

    public function create(Skill $skill): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO skill (name, level) 
            VALUES (:name, :level)'
        );
        $stmt->bindValue(":name", $skill->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":level", $skill->getLevel(), \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function update(Skill $skill): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE skill 
            SET name = :name, level = :level 
            WHERE id = :id'
        );
        $stmt->bindValue(":name", $skill->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":level", $skill->getLevel(), \PDO::PARAM_INT);
        $stmt->bindValue(":id", $skill->getId(), \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM skill 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

}
