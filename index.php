<?php


spl_autoload_register(function($classname){
    $path = lcfirst(str_replace('\\','/',$classname));
    $filename = $path.'.php';

    if(file_exists($filename)){
        include $filename;
    }
});








$content = "views/404/404.phtml";
$title = "test";

include ("views/layout.phtml");