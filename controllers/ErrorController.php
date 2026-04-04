<?php

namespace Controllers;

class ErrorController{

    public function index(): void
    {
        $content = "views/error/error.phtml";
        $title = "Erreur";

        include ("views/layout.phtml");
    }

}