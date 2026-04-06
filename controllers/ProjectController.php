<?php


namespace Controllers;

use Repositories\ProjectRepository;
use Repositories\PictureRepository;
use Repositories\SkillRepository;


class ProjectController extends AbstractController {
    public function index(): void  {
        
        $projectID = $_GET["id"];

        $pictureRepository = new PictureRepository();
        $projectPictures = $pictureRepository->getByProject($projectID);
        
        $projectRepository = new ProjectRepository();
        $project = $projectRepository->getById($projectID);
        

        $skillRepository = new SkillRepository();

        $projectSkills = [];
        $projectSkills[$project->getId()] = $skillRepository->getByProject($project->getId());





        $layoutName = $this->layoutName();

        $content = "views/project/project.phtml";
        $title = "Projet";

        include ("views/layout.phtml");
    }
}