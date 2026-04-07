<?php

namespace Controllers;

use Repositories\ProfilRepository;

//classe abstraite qui va notament servire pour le back end du layout
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