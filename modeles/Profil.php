<?php

namespace Modeles;

class Profil
{
    private ?int $id = null;
    private string $name ;
    private string $description;
    private string $email;
    private string $phone;
    private string $github;
    private string $cv;
    private ?int $id_picture = null;

    public function __construct(?int $id , string $name, string $description, string $email, string $phone, string $github, string $cv, ?int $id_picture = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->email = $email;
        $this->phone = $phone;
        $this->github = $github;
        $this->cv = $cv;
        $this->id_picture = $id_picture;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getGithub(): string
    {
        return $this->github;
    }

    public function getCv(): string
    {
        return $this->cv;
    }

    public function getIdPicture(): ?int
    {
        return $this->id_picture;
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

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setGithub(string $github): void
    {
        $this->github = $github;
    }

    public function setCv(string $cv): void
    {
        $this->cv = $cv;
    }

    public function setIdPicture(?int $id_picture): void
    {
        $this->id_picture = $id_picture;
    }
}
