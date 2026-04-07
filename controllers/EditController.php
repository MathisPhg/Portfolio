<?php


namespace Controllers;

use Repositories\ProjectRepository;
use Repositories\PictureRepository;
use Repositories\CategoryRepository;
use Repositories\SkillRepository;
use Modeles\Project;
use Modeles\Picture;
use Modeles\Skill;
use Modeles\Category;


class EditController extends AbstractController
{

    public function index(): void
    {

        //verifie si l'utilisateur est  connecter sinon le redirige vers la page d'accueil
        if (empty($_SESSION["user"])) {
            header("Location: ?page=home");
            exit();
        }


        //regarde qu'est ce qu'on veux modifier
        switch ($_GET["type"] ?? "") {
            case "project":


                $projectRepository = new ProjectRepository();
                $categoryRepository = new CategoryRepository();
                $skillRepository = new SkillRepository();
                $pictureRepository = new PictureRepository();
                
                //verifie si le formulaire de modification du projet a deja ete soumit et si les champs sont remplie sinon
                if (isset($_POST["submit"])) {
                    if (isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["category"]) && isset($_POST["skills"]) && (isset($_FILES["Project_Images"]) || !empty($pictureRepository->getByProject($_GET["id"]))) ) {
                        
                        //stocke tout dans des variable
                        $title = $_POST["title"];
                        $content = $_POST["content"];
                        $category = $_POST["category"];
                        $skillsId = $_POST["skills"];
                        $images = $_FILES["Project_Images"];
                        
                        
                        try {

                            //update du projet en base de donnée
                            $newProject = new Project($_GET["id"], $title, $content, $category);
                            $projectRepository->update($newProject);

                            $newProject = $projectRepository->getById($_GET["id"]);
                            
                            //updete des skills du projet en base de donnée
                            $allSkills = $skillRepository->getByProject($_GET["id"]);
                            foreach ($allSkills as $skill) {
                                $projectRepository->removeSkill($_GET["id"], $skill->getId());
                            }
                            foreach ($skillsId as $skillId) {
                                $projectRepository->addSkill($newProject->getId(), $skillId);
                            }
                            
                            //update des images du projet en base de donnée
                            foreach ($images["tmp_name"] as $index => $tmpName) {

                                if ($images["error"][$index] === 0) {
                                    $imageName = uniqid() . "_" . basename($images["name"][$index]);
                                    move_uploaded_file($tmpName, "assets/images/" . $imageName);

                                    $picture = new Picture(null, "assets/images/" . $imageName, $newProject->getId());
                                    $pictureRepository->create($picture);
                                }
                            }

                            header("Location: ?page=list&list=project");
                            exit();
                        } catch (\Exception $e) {
                            $error = "Une erreur est survenue lors de la mise à jour du projet.";
                        }

                    } else {
                        $error = "Veuillez remplir tous les champs et ajouter au moins une image.";
                    }
                }
                
                //verifie si on veux suppprimer une image
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



                //recupere les données du projet pour les afficher dans le form
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
                //meme principe que pour le projet mais avec les skills
                
                
                try {
                    if (isset($_GET["id"])) {
                        $skillRepository = new SkillRepository();
                        $skill  = $skillRepository->getById($_GET["id"]);
                    }

                    if (isset($_POST["submit"])) {

                        if (!empty($_POST["name"])) {

                            $name = $_POST["name"];
                            $level = $_POST["level"];

                            try {
                                $updatedSkill = new Skill($_GET["id"], $name, $level);
                                $skillRepository->update($updatedSkill);

                                header("Location: ?page=list&list=skill");
                                exit();
                            } catch (\Exception $e) {
                                $error = "Une erreur est survenue lors de la mise à jour de la compétence.";
                            }

                        } else {
                            $error = "Veuillez remplir tous les champs";
                        }


                    }


               
                } catch (\Exception $e) {
                    $error = "Une erreur est survenue lors de la récupération de la compétence.";
                }



                break;
            case "category":
                //meme principe que pour le projet mais avec les categories


                try {
                    if (isset($_GET["id"])) {
                        $categoryRepository = new CategoryRepository();
                        $category  = $categoryRepository->getById($_GET["id"]);
                    }

                    if (isset($_POST["submit"])) {

                        if (!empty($_POST["name"])) {

                            $name = $_POST["name"];
                            $level = $_POST["level"];

                            try {
                                $updatedCategory = new Category($_GET["id"], $name);
                                $categoryRepository->update($updatedCategory);

                                header("Location: ?page=list&list=category");
                                exit();
                            } catch (\Exception $e) {
                                $error = "Une erreur est survenue lors de la mise à jour de la catégorie.";
                            }

                        } else {
                            $error = "Veuillez remplir tous les champs";
                        }


                    }


               
                } catch (\Exception $e) {
                    $error = "Une erreur est survenue lors de la récupération de la catégorie.";
                }





                break;
            default:
                header("Location: ?page=dashboard");
                exit();
        }







        $layoutName = $this->layoutName();

        $content = "views/create/createdit.phtml";
        $title = "Modifier";

        include ("views/layout.phtml");
        
    }

}