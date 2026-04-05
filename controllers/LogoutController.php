<?php

namespace Controllers;


class LogoutController extends AbstractController {
    public function index(): void  {
        session_destroy();
        header("Location: /?page=home");
        exit();
    }
}