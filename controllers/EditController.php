<?php


namespace Controllers;

class EditController extends AbstractController
{

    public function index(): void
    {
        
        if (empty($_SESSION["user"])) {
            header("Location: /?page=home");
            exit();
        }


        $layoutName = $this->layoutName();

        $content = "views/create/createdit.phtml";
        $title = "Modifier";

        include ("views/layout.phtml");
        
    }

}