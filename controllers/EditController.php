<?php


namespace Controllers;

class EditController extends AbstractController
{

    public function index(): void
    {
        $layoutName = $this->layoutName();

        $content = "views/create/createdit.phtml";
        $title = "Modifier";

        include ("views/layout.phtml");
        
    }

}