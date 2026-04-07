<?php

namespace Controllers;

use Repositories\ProfilRepository;
use Repositories\PictureRepository;
use Repositories\ProjectRepository;
use Repositories\SkillRepository;
use Repositories\CategoryRepository;

use Modeles\Picture;
use Modeles\Profil;

class DashboardController extends AbstractController {
    public function index(): void {
        

        //verifie si l'utilisateur est  connecter sinon le redirige vers la page d'accueil
        if (empty($_SESSION["user"])) {
            header("Location: ?page=home");
            exit();
        }
        
        //récupère les informations du profil pour les afficher dans le dashboard
        $profilRepository = new ProfilRepository();
        $profil = $profilRepository->getById(1);

        //récupère les informations de l'image du profil pour les afficher dans le dashboard
        $pictureRepository = new PictureRepository();
        $picture = $pictureRepository->getById($profil->getIdPicture());

        //récupère le nombre de projet pour les afficher dans le dashboard
        $projectRepository = new ProjectRepository();
        $projectNb = $projectRepository->getNumber();

        //récupère le nombre de skill pour les afficher dans le dashboard
        $skillRepository = new SkillRepository();
        $skillNb = $skillRepository->getNumber();

        //récupère le nombre de catégorie pour les afficher dans le dashboard
        $categoryRepository = new CategoryRepository();
        $categoryNb = $categoryRepository->getNumber();


        //verifie si le formulaire de modification du profil a deja ete soumit et si les champs sont remplie sinon
        if (isset($_POST["submit"])) {
            if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["description"]) && (isset($_FILES["profil_image_input"]) || !empty($pictureRepository->getById($profil->getIdPicture()))) && (isset($_FILES["cv"]) || !empty($profil->getCv()))) {
                
                
                try {

                    //stocke tout dans des variable
                    $name = $_POST["name"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $description = $_POST["description"];
                    $profil_image = $_FILES["profil_image_input"];
                    $cv = $_FILES["cv"];

                    
                    //verifie si il y a de nouveau ficchier si oui met a jour la base de donnée et met les fichier dans le dossier assets/images
                    if ($profil_image["error"] !== UPLOAD_ERR_NO_FILE) {
                        
                        unlink($picture->getLink());
                        $pictureRepository->delete($picture->getId());

                        
                        $newProfilPictureName = uniqid() . "_" . basename($profil_image["name"]);
                        $newProfilPicturePath = "assets/images/" . $newProfilPictureName;
                        $newProfilPicture = new Picture(null,$newProfilPicturePath, null);
                        move_uploaded_file($profil_image["tmp_name"], $newProfilPicturePath);
                        $pictureRepository->create($newProfilPicture);

                        $ProfilPictureId = $pictureRepository->getLastInsertId();
                        
                    } else {
                        $ProfilPictureId = $picture->getId();
                    }

                    if ($cv["error"] !== UPLOAD_ERR_NO_FILE) {
                        
                        unlink($profil->getCv());
                        $newCvName = uniqid() . "_" . basename($cv["name"]);
                        $newCvPath = "assets/images/" . $newCvName;
                        move_uploaded_file($cv["tmp_name"], $newCvPath);



                    } else {
                        $newCvPath = $profil->getCv();
                    }

                    //update du profil en base de donnée
                    $newProfil = new Profil($profil->getId(), $name, $description, $email, $phone, $profil->getGithub(), $newCvPath, $ProfilPictureId);

                    $profilRepository->update($newProfil);
                    
                    


                    header("Location: ?page=dashboard");
                    exit();
                } catch (\Exception $e) {
                    $error = "Une erreur est survenue lors de la mise à jour du projet.";
                }

            } else {
                $error = "Veuillez remplir tous les champs et ajouter au moins une image.";
            }
        }
        



        $layoutName = $this->layoutName();


        $content = "views/dashboard/dashboard.phtml";
        $title = "Dashboard";

        include ("views/layout.phtml");
    }
}

