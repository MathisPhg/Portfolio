<?php

namespace Controllers;

class DashboardController {
    public function index() {
        $content = "views/dashboard/dashboard.phtml";
        $title = "Dashboard";

        include ("views/layout.phtml");
    }
}

