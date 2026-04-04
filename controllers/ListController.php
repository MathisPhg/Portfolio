<?php

namespace Controllers;


class ListController {

    public function index() {
        $content = "views/list/list.phtml";
        $title = "Liste";

        include ("views/layout.phtml");
    }
    
}