<?php

namespace Controllers;


use Repositories\ProjectRepository;
use Repositories\PictureRepository;
use Repositories\CategoryRepository;
use Repositories\SkillRepository;
use Modeles\Project;
use Modeles\Picture;

class CreateController extends AbstractController
{

    public function index(): void
    {

        if (empty($_SESSION["user"])) {
            header("Location: /?page=home");
            exit();
        }

        switch ($_GET["type"]) {
            case "project":


                if (isset($_POST["submit"])) {
                    if (isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["category"]) && isset($_POST["skills"]) && isset($_FILES["Project_Images"]) ) {

                        foreach ($_FILES["Project_Images"]["type"] as $index => $type) {
                            if (!str_contains($type, "image")) {
                                $error = "Veuillez ajouter une image.";
                                break;
                            }
                        }

                    

                        $title = $_POST["title"];
                        $content = $_POST["content"];
                        $category = $_POST["category"];
                        $skillsId = $_POST["skills"];
                        $images = $_FILES["Project_Images"];

                        $project = new Project(null, $title, $content, $category);
                        $projectRepository = new ProjectRepository();
                        $projectRepository->create($project);

                        $newProject = $projectRepository->getByName($title);


                        foreach ($skillsId as $skillId) {
                            $projectRepository->addSkill($newProject->getId(), $skillId);
                        }

                        $pictureRepository = new PictureRepository();
                        foreach ($images["tmp_name"] as $index => $tmpName) {
                            if ($images["error"] === 0) {
                                $imageName = uniqid() . "_" . basename($images["name"][$index]);
                                move_uploaded_file($tmpName, "assets/images/" . $imageName);
                                $picture = new Picture(null, "assets/images/" . $imageName, $newProject->getId());
                                $pictureRepository->create($picture);
                            }
                        }
                        
                        header("Location: index.php?page=list&list=project");
                        exit();

                    

                    } else {
                        $error = "Veuillez remplir tous les champs";
                    }
                }




                $categoryRepository = new CategoryRepository();
                $categories = $categoryRepository->getAll();

                $skillRepository = new SkillRepository();
                $skills = $skillRepository->getAll();

                



                break;
            case "skill":










                break;
            case "category":











                break;
            default:
                header("Location: /?page=dashboard");
                exit();
        }


        $layoutName = $this->layoutName();

        $content = "views/create/createdit.phtml";
        $title = "Créer";

        include ("views/layout.phtml");
        

    }

}