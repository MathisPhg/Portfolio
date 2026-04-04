<?php


namespace Controllers;

class LoginController {

    public function index() {
        $content = "views/login/login.phtml";
        $title = "Login";

        include ("views/layout.phtml");
    }
}