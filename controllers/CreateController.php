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

class CreateController extends AbstractController
{

    public function index(): void
    {

        //verifie si l'utilisateur est  connecter sinon le redirige vers la page d'accueil
        if (empty($_SESSION["user"])) {
            header("Location: ?page=home");
            exit();
        }
        
        //regarde qu'est ce qu'on veux creer
        switch ($_GET["type"]) {

        //si on veux creer un projet
            case "project":
                
                
                //verifie si le formulaire a deja ete soumit et si les champs sont remplie sinon
                if (isset($_POST["submit"])) {
                    if (isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["category"]) && isset($_POST["skills"]) && isset($_FILES["Project_Images"]) ) {
                        
                        //verifie que les fichier envoyer soit bien des images
                        foreach ($_FILES["Project_Images"]["type"] as $index => $type) {
                            if (!str_contains($type, "image")) {
                                $error = "Veuillez ajouter une image.";
                                break;
                            }
                        }


                        //stocke tout dans des variable
                        $title = $_POST["title"];
                        $content = $_POST["content"];
                        $category = $_POST["category"];
                        $skillsId = $_POST["skills"];
                        $images = $_FILES["Project_Images"];

                        try {

                            //ajoute le projet en base de donnée
                            $project = new Project(null, $title, $content, $category);
                            $projectRepository = new ProjectRepository();
                            $projectRepository->create($project);

                            $newProject = $projectRepository->getByName($title);

                            //ajoute les skill du projet en base de donnée
                            foreach ($skillsId as $skillId) {
                                $projectRepository->addSkill($newProject->getId(), $skillId);
                            }

                            //ajoute les chemins des images du projet en base de donnée et dans le dossier assets/images
                            $pictureRepository = new PictureRepository();
                            foreach ($images["tmp_name"] as $index => $tmpName) {
                                if ($images["error"][$index] === 0) {
                                    $imageName = uniqid() . "_" . basename($images["name"][$index]);
                                    move_uploaded_file($tmpName, "assets/images/" . $imageName);
                                    $picture = new Picture(null, "assets/images/" . $imageName, $newProject->getId());
                                    $pictureRepository->create($picture);
                                }
                            }
                            
                            //redirige vers la liste des projets
                            header("Location: ?page=list&list=project");
                            exit();
                        } catch (\Exception $e) {
                            $error = "Une erreur est survenue lors de la création du projet.";
                        }

                    } else {
                        $error = "Veuillez remplir tous les champs";
                    }
                }



                //récupère toutes les catégories et compétences pour les afficher dans le formulaire
                $categoryRepository = new CategoryRepository();
                $categories = $categoryRepository->getAll();


                //récupère toutes les skill pour les afficher dans le formulaire
                $skillRepository = new SkillRepository();
                $skills = $skillRepository->getAll();

                



                break;
            case "skill":

                //sensiblement la meme chose que pour le projet mais plus simple vu qu'il y a moins de champs a remplir et pas de fichier a envoyer

                try {

                    
                    if (isset($_POST["submit"])) {
                        if (!empty($_POST["name"])) {

                            $name = $_POST["name"];
                            $level = $_POST["level"];

                            try {
                                $skill = new Skill(null, $name, $level);
                                $skillRepository = new SkillRepository();
                                $skillRepository->create($skill);

                                header("Location: ?page=list&list=skill");
                                exit();
                            } catch (\Exception $e) {
                                $error = "Une erreur est survenue lors de la création de la compétence.";
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

                //sensiblement la meme chose que pour le projet mais plus simple vu qu'il y a moins de champs a remplir et pas de fichier a envoyer



                try {

                    if (isset($_POST["submit"])) {
                        if (!empty($_POST["name"])) {

                            $name = $_POST["name"];
                            

                            try {
                                $category = new Category(null, $name);
                                $categoryRepository = new CategoryRepository();
                                $categoryRepository->create($category);

                                header("Location: ?page=list&list=category");
                                exit();
                            } catch (\Exception $e) {
                                $error = "Une erreur est survenue lors de la création de la catégorie.";
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
        $title = "Créer";

        include ("views/layout.phtml");
        

    }

}