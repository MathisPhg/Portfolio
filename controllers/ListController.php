<?php

namespace Controllers;


class ListController extends AbstractController {

    public function index(): void  {
        $layoutName = $this->layoutName();

        $content = "views/list/list.phtml";
        $title = "Liste";

        include ("views/layout.phtml");
    }
    
}