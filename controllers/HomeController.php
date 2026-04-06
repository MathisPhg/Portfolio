<?php

namespace Controllers;

use Repositories\ProfilRepository;
use Repositories\PictureRepository;
use Repositories\ProjectRepository;
use Repositories\CategoryRepository;

class HomeController extends AbstractController
{

    public function index(): void
    {

        $profilRepository = new ProfilRepository();
        $profil = $profilRepository->getById(1);



        $projectRepository = new ProjectRepository();
        $projects = $projectRepository->getAll();

        
        $categoryRepository = new CategoryRepository();
        $projectCategories = [];
        foreach ($projects as $project) {
            $category = $categoryRepository->getById($project->getIdCategory());
            $projectCategories[$project->getId()] = $category ? [$category] : [];
        }


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