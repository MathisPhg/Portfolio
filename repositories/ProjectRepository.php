<?php

namespace Repositories;

use Modeles\Project;
use Services\Database;

class ProjectRepository
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
        $stmt = $this->pdo->query(
            'SELECT * FROM project 
            ORDER BY name'
        );
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $projectlist = [];
        foreach ($result as &$project) {
            $projectlist[] = new Project( $project['id'], $project['name'], $project['description'], $project['id_category']);
        }
        return $projectlist;

    }

    public function getById(int $id): ?Project
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM project 
            WHERE id = :id'
        );
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }
        $project = new Project($result['id'], $result['name'], $result['description'], $result['id_category']);

        return $project;
    }

    public function getByName(string $name): ?Project
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM project 
            WHERE name = :name'
        );
        $stmt->bindValue(":name", $name, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }
        $project = new Project($result['id'], $result['name'], $result['description'], $result['id_category']);

        return $project;
    }

    public function getNumber(): int 
    {
        $stmt = $this->pdo->query(
            'SELECT COUNT(*) FROM project'
        );
        $result = $stmt->fetchColumn();
        return (int)$result;
    }

    // public function getByCategory(int $idCategory): array
    // {
    //     $stmt = $this->pdo->prepare('SELECT * FROM project WHERE id_category = :id_category ORDER BY name');
    //     $stmt->bindParam(":id_category", $idCategory, \PDO::PARAM_INT);
    //     $stmt->execute();
    //     $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //     return $result;

    // }

    public function create(Project $project): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO project (name, description, id_category) 
            VALUES (:name, :description, :id_category)'
        );
        $stmt->bindValue(":name", $project->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":description", $project->getDescription(), \PDO::PARAM_STR);
        $stmt->bindValue(":id_category", $project->getIdCategory(), \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function update(Project $project): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE project 
            SET name = :name, description = :description, id_category = :id_category 
            WHERE id = :id'
        );
        $stmt->bindValue(":name", $project->getName(), \PDO::PARAM_STR);
        $stmt->bindValue(":description", $project->getDescription(), \PDO::PARAM_STR);
        $stmt->bindValue(":id_category", $project->getIdCategory(), \PDO::PARAM_INT);
        $stmt->bindValue(":id", $project->getId(), \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;

    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM project 
            WHERE id = :id'
        );
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function addSkill(int $projectId, int $skillId): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO project_skill (id_project, id_skill) 
            VALUES (:id_project, :id_skill)'
        );
        $stmt->bindParam(":id_project", $projectId, \PDO::PARAM_INT);
        $stmt->bindParam(":id_skill", $skillId, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function removeSkill(int $projectId, int $skillId): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM project_skill 
            WHERE id_project = :id_project AND id_skill = :id_skill'
        );
        $stmt->bindParam(":id_project", $projectId, \PDO::PARAM_INT);
        $stmt->bindParam(":id_skill", $skillId, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

}
