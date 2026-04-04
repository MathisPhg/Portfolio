<?php


namespace Controllers;

class EditController extends AbstractFormController
{

    public function index(string $title = ""): void
    {
        parent::index("Modifier");
        
    }

}