<?php

namespace Controllers;

use Repositories\ProfilRepository;
use Repositories\PictureRepository;
use Repositories\ProjectRepository;
use Repositories\CategoryRepository;
use Repositories\SkillRepository;

class HomeController extends AbstractController
{

    public function index(): void
    {
        
        try {

            //recupere les données du profil pour les afficher dans la page d'accueil
            $profilRepository = new ProfilRepository();
            $profil = $profilRepository->getById(1);


            //recupere les données des projets pour les afficher dans la page d'accueil
            $projectRepository = new ProjectRepository();
            $projects = $projectRepository->getAll();

            //recupere les données des categories pour les afficher dans la page d'accueil
            $categoryRepository = new CategoryRepository();
            $categories = $categoryRepository->getAll();
            $projectCategories = [];
            foreach ($projects as $project) {
                $category = $categoryRepository->getById($project->getIdCategory());
                $projectCategories[$project->getId()] = $category ? [$category] : [];
            }
            
            //recupere les données des skills pour les afficher dans la page d'accueil
            $skillRepository = new SkillRepository();
            $skills = $skillRepository->getAll();
            $projectSkills = [];
            foreach ($projects as $project) {
                $projectSkills[$project->getId()] = $skillRepository->getByProject($project->getId());
            }
            
            //recupere les données des images pour les afficher dans la page d'accueil
            $pictureRepository = new PictureRepository();
            $picture = $pictureRepository->getById($profil->getIdPicture());
            $projectPictures = [];
            foreach ($projects as $project) {
                $projectPictures[$project->getId()] = $pictureRepository->getFirst($project->getId());
            }

        } catch (\Exception $e) {
            $error = "Une erreur est survenue lors du chargement de la page.";
        }



        $layoutName = $this->layoutName();

        $content = "views/home/home.phtml";
        $title = "Accueil";

        include ("views/layout.phtml");
    }

}