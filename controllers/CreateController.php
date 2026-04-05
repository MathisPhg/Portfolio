<?php

namespace Controllers;

class CreateController extends AbstractController
{

    public function index(): void
    {
        $layoutName = $this->layoutName();

        $content = "views/create/createdit.phtml";
        $title = "Créer";

        include ("views/layout.phtml");
        

    }

}