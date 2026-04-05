<?php
session_start();

spl_autoload_register(function($classname){
    $path = lcfirst(str_replace('\\','/',$classname));
    $filename = $path.'.php';

    if(file_exists($filename)){
        include $filename;
    }
});

require_once "configs/settings.php";
require_once "services/Router.php";

use Services\Router;



$page = $_GET['page'] ?? 'home';

$router = new Router($page);

$router->getController();


