<?php


namespace Controllers;

use Repositories\UserRepository;


class LoginController extends AbstractController {

    public function index(): void  {
        $layoutName = $this->layoutName();

        $error = null;

        //verifie si le form a ete soumis
        if (isset($_POST["submit"])) {
            
            //verifie si les champs sont remplie sinon affiche une erreur
            if (isset($_POST["name"]) && isset($_POST["password"])) {
                
                //stocke les données du formulaire dans des variables
                $name = $_POST["name"];
                $password = $_POST["password"];

                try {
                    $userRepository = new UserRepository();
                    $user = $userRepository->getByName($name);

                    //verifie si le mot de passe et le nom sont correct et connecte l'utilisateur sinon affiche une erreur
                    if (isset($user) && password_verify($password, $user->getPassword())) {
                        $_SESSION["user"] = $user->getId();
                        header("Location: ?page=dashboard");
                        exit();
                    } else {
                        $error = "Nom d'utilisateur ou mot de passe incorrect";
                    }
                } catch (\Exception $e) {
                    $error = "Une erreur est survenue lors de la connexion.";
                }

            } else {
                $error = "Veuillez remplir tous les champs";
            }
        }


        $content = "views/login/login.phtml";
        $title = "Login";

        include ("views/layout.phtml");
    }
}