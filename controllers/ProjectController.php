<?php


namespace Controllers;


class ProjectController {
    public function index() {
        $content = "views/project/project.phtml";
        $title = "Projet";

        include ("views/layout.phtml");
    }
}