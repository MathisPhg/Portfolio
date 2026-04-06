<?php


namespace Controllers;

use Repositories\ProjectRepository;
use Repositories\PictureRepository;
use Repositories\CategoryRepository;
use Repositories\SkillRepository;
use Modeles\Project;
use Modeles\Picture;


class EditController extends AbstractController
{

    public function index(): void
    {

        if (empty($_SESSION["user"])) {
            header("Location: /?page=home");
            exit();
        }



        switch ($_GET["type"] ?? "") {
            case "project":


                $projectRepository = new ProjectRepository();
                $categoryRepository = new CategoryRepository();
                $skillRepository = new SkillRepository();
                $pictureRepository = new PictureRepository();

                if (isset($_POST["submit"])) {
                    if (isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["category"]) && isset($_POST["skills"]) && (isset($_FILES["Project_Images"]) || !empty($pictureRepository->getByProject($_GET["id"]))) ) {

                        $title = $_POST["title"];
                        $content = $_POST["content"];
                        $category = $_POST["category"];
                        $skillsId = $_POST["skills"];
                        $images = $_FILES["Project_Images"];

                        try {
                            $newProject = new Project($_GET["id"], $title, $content, $category);
                            $projectRepository->update($newProject);

                            $newProject = $projectRepository->getById($_GET["id"]);

                            $allSkills = $skillRepository->getByProject($_GET["id"]);
                            foreach ($allSkills as $skill) {
                                $projectRepository->removeSkill($_GET["id"], $skill->getId());
                            }
                            foreach ($skillsId as $skillId) {
                                $projectRepository->addSkill($newProject->getId(), $skillId);
                            }

                            foreach ($images["tmp_name"] as $index => $tmpName) {

                                if ($images["error"][$index] === 0) {
                                    $imageName = uniqid() . "_" . basename($images["name"][$index]);
                                    move_uploaded_file($tmpName, "assets/images/" . $imageName);
                                    
                                    $picture = new Picture(null, "assets/images/" . $imageName, $newProject->getId());
                                    $pictureRepository->create($picture);
                                }
                            }

                            header("Location: index.php?page=list&list=project");
                            exit();
                        } catch (\Exception $e) {
                            $error = "Une erreur est survenue lors de la mise à jour du projet.";
                        }

                    } else {
                        $error = "Veuillez remplir tous les champs et ajouter au moins une image.";
                    }
                }

                if (isset($_GET["delete"])) {
                    try {
                        $pictureToDelete = $pictureRepository->getById((int)$_GET["delete"]);
                        if ($pictureToDelete !== null) {
                            unlink($pictureToDelete->getLink());
                            $pictureRepository->delete((int)$_GET["delete"]);
                        }
                    } catch (\Exception $e) {
                        $error = "Une erreur est survenue lors de la suppression de l'image.";
                    }
                }



                $pictures = $pictureRepository->getByProject($_GET["id"]);

                $project = $projectRepository->getById($_GET["id"]);

                $categories = $categoryRepository->getAll();

                $skills = $skillRepository->getAll();

                
                $selectedSkillIds = [];
                foreach ($skillRepository->getByProject($_GET["id"]) as $skill) {
                    $selectedSkillIds[] = $skill->getId();
                }

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
        $title = "Modifier";

        include ("views/layout.phtml");
        
    }

}