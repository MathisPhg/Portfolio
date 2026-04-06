<?php


namespace Controllers;

use Repositories\ProjectRepository;
use Repositories\PictureRepository;


class ProjectController extends AbstractController {
    public function index(): void  {
        
        $projectID = $_GET["id"];

        $pictureRepository = new PictureRepository();
        $projectPictures = $pictureRepository->getByProject($projectID);
        
        $projectRepository = new ProjectRepository();
        $project = $projectRepository->getById($projectID);
        




        $layoutName = $this->layoutName();

        $content = "views/project/project.phtml";
        $title = "Projet";

        include ("views/layout.phtml");
    }
}