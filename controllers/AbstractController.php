<?php

namespace Controllers;

use Repositories\ProfilRepository;

abstract class AbstractController
{   

    protected function index(): void
    {

    }

    protected function layoutName(): string {
        $profilRepository = new ProfilRepository();
        $profil = $profilRepository->getById(1);
        return $profil->getName();
    }

}