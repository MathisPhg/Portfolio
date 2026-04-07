<?php

namespace Controllers;

use Repositories\ProjectRepository;
use Repositories\CategoryRepository;
use Repositories\PictureRepository;
use Repositories\SkillRepository;
class ListController extends AbstractController {

    public function index(): void  {

        //verifie si l'utilisateur est  connecter sinon le redirige vers la page d'accueil
        if (empty($_SESSION["user"])) {
            header("Location: ?page=home");
            exit();
        }

        $categoryRepository = new CategoryRepository();
        $pictureRepository = new PictureRepository();
        $projectRepository = new ProjectRepository();
        $skillRepository = new SkillRepository();
        
        //regarde quelle liste on veux afficher
        switch ($_GET["list"]) {
            case "project":
                $projects = $projectRepository->getAll();
                
                //recupere les images des projets pour les afficher dans la liste
                foreach ($projects as $project) {
                $pictures[$project->getId()] = $pictureRepository->getFirst($project->getId());
                }
                
                //recupere les categories des projets pour les afficher dans la liste
                $categories = [];
                foreach ($categoryRepository->getAll() as $cat) {
                    $categories[$cat->getId()] = $cat;
                }


                //regare si on veux supprimer un projet et le supprime si c'est le cas
                if (isset($_GET["delete"])) {
                    try {
                        $picturelist = $pictureRepository->getByProject($_GET["delete"]);
                        foreach ($picturelist as $picture) {
                            unlink($picture->getLink());
                        }
                        $projectRepository->delete($_GET["delete"]);
                        header("Location: ?page=list&list=project");
                        exit();
                    } catch (\Exception $e) {
                        $error = "Une erreur est survenue lors de la suppression.";
                    }
                }

                $skillRepository = new SkillRepository();
                $skills = [];
                foreach ($projects as $project) {
                    $skills[$project->getId()] = $skillRepository->getByProject($project->getId());
                }

            break;
            case "skill":
                //meme principe que pour le projet mais avec les skills

                $skills = $skillRepository->getAll();

                if (isset($_GET["delete"])) {
                    try {
                        $skillRepository->delete($_GET["delete"]);
                        header("Location: ?page=list&list=skill");
                        exit();
                    } catch (\Exception $e) {
                        $error = "Une erreur est survenue lors de la suppression, Veuillez dissocier toutes les compétences des projets associés avant de la supprimer.";
                    }
                }


                break;

            case "category":
                //meme principe que pour le projet mais avec les categories



                $categories = $categoryRepository->getAll();


                if (isset($_GET["delete"])) {
                    try {
                        $categoryRepository->delete($_GET["delete"]);
                        header("Location: ?page=list&list=category");
                        exit();
                    } catch (\Exception $e) {
                        $error = "Une erreur est survenue lors de la suppression, Veuillez dissocier tous les projets associés à cette catégorie avant de la supprimer.";
                    }
                }




                break;

            default:
                header("Location: ?page=home");
                exit();
        }

        $layoutName = $this->layoutName();

        $content = "views/list/list.phtml";
        $title = "Liste";

        include ("views/layout.phtml");



    }
    
}