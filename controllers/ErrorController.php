<?php

namespace Controllers;

class ErrorController extends AbstractController{

    public function index(): void
    {
        $layoutName = $this->layoutName();

        $content = "views/error/error.phtml";
        $title = "Erreur";

        include ("views/layout.phtml");
    }

}