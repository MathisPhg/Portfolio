<?php

namespace Modeles;

class Picture
{
    private ?int $id = null;
    private string $link;
    private ?int $id_project;

    public function __construct(?int $id, string $link, ?int $id_project = null)
    {
        $this->id = $id;
        $this->link = $link;
        $this->id_project = $id_project;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getIdProject(): ?int
    {
        return $this->id_project;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function setIdProject(?int $id_project): void
    {
        $this->id_project = $id_project;
    }
}
