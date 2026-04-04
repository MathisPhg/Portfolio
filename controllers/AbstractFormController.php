<?php

namespace Controllers;

abstract class AbstractFormController
{   

    public function index(string $name): void
    {
        $content = "views/create/createdit.phtml";
        $title = $name;

        include ("views/layout.phtml");
    }    

}