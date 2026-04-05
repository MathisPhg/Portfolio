<?php

namespace Controllers;

class HomeController extends AbstractController
{

    public function index(): void
    {
        $layoutName = $this->layoutName();

        $content = "views/home/home.phtml";
        $title = "Accueil";

        include ("views/layout.phtml");
    }

}