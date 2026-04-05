<?php

namespace Controllers;

use Repositories\ProfilRepository;
use Repositories\PictureRepository;
use Repositories\ProjectRepository;
use Repositories\SkillRepository;
use Repositories\CategoryRepository;

class DashboardController extends AbstractController {
    public function index(): void {
        $layoutName = $this->layoutName();

        if (empty($_SESSION["user"])) {
            header("Location: /?page=home");
            exit();
        }
    
        $profilRepository = new ProfilRepository();
        $profil = $profilRepository->getById(1);

        $pictureRepository = new PictureRepository();
        $picture = $pictureRepository->getById($profil->getIdPicture());

        $projectRepository = new ProjectRepository();
        $projectNb = $projectRepository->getNumber();

        $skillRepository = new SkillRepository();
        $skillNb = $skillRepository->getNumber();

        $categoryRepository = new CategoryRepository();
        $categoryNb = $categoryRepository->getNumber();


        $content = "views/dashboard/dashboard.phtml";
        $title = "Dashboard";

        include ("views/layout.phtml");
    }
}

