<?php

namespace Controllers;

use Repositories\ProfilRepository;
use Repositories\PictureRepository;
use Repositories\ProjectRepository;

class HomeController extends AbstractController
{

    public function index(): void
    {

        $profilRepository = new ProfilRepository();
        $profil = $profilRepository->getById(1);



        $projectRepository = new ProjectRepository();
        $projects = $projectRepository->getAll();

        $pictureRepository = new PictureRepository();
        $picture = $pictureRepository->getById($profil->getIdPicture());
        $projectPictures = [];
        foreach ($projects as $project) {
            $projectPictures[$project->getId()] = $pictureRepository->getFirst($project->getId());
        }



        $layoutName = $this->layoutName();

        $content = "views/home/home.phtml";
        $title = "Accueil";

        include ("views/layout.phtml");
    }

}