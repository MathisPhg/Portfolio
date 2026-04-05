<?php

namespace Controllers;

use Repositories\ProjectRepository;
use Repositories\CategoryRepository;
use Repositories\PictureRepository;
class ListController extends AbstractController {

    public function index(): void  {

        if (empty($_SESSION["user"])) {
            header("Location: /?page=home");
            exit();
        }

        $categoryRepository = new CategoryRepository();
        $pictureRepository = new PictureRepository();
        $projectRepository = new ProjectRepository();

        switch ($_GET["list"]) {
            case "project":
                $projects = $projectRepository->getAll();

                foreach ($projects as $project) {
                    
                $picture[$project->getId()] = $pictureRepository->getFirst($project->getId());
                }

                $categories = [];
                foreach ($categoryRepository->getAll() as $cat) {
                    $categories[$cat->getId()] = $cat;
                }


                
                if (isset($_GET["delete"])) {

                    $picturelist = $pictureRepository->getByProject($_GET["delete"]);
                    foreach ($picturelist as $picture) {
                        unlink($picture->getLink());
                    }

                    $projectRepository->delete($_GET["delete"]);

                    header("Location: index.php?page=list");
                    exit();
                }
                



            break;
            case "skill":
                break;
            case "category":
                break;
                default:
                header("Location: /?page=home");
                exit();
        }

        $layoutName = $this->layoutName();

        $content = "views/list/list.phtml";
        $title = "Liste";

        include ("views/layout.phtml");



    }
    
}