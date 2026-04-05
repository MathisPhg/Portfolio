<?php

namespace Modeles;

class Project
{
    private int $id;
    private string $name;
    private string $description;
    private int $id_category;

    public function __construct(int $id, string $name, string $description, int $id_category)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->id_category = $id_category;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIdCategory(): int
    {
        return $this->id_category;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setIdCategory(int $id_category): void
    {
        $this->id_category = $id_category;
    }
}
