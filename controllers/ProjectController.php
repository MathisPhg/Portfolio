<?php


namespace Controllers;


class ProjectController extends AbstractController {
    public function index(): void  {
        $layoutName = $this->layoutName();

        $content = "views/project/project.phtml";
        $title = "Projet";

        include ("views/layout.phtml");
    }
}