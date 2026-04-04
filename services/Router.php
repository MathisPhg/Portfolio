<?php

namespace Services;

require_once './configs/settings.php';

class Router
{
    private string $controller;
    private string $method;

    public function __construct(string $page = "home")
    {

        try {
            if (!array_key_exists($page, AVAILABLE_ROUTES)) {
                throw new \Exception("Page not found");
            }
        } catch (\Exception $e) {

            $page = "404";
        }
        $this->controller = AVAILABLE_ROUTES[$page]['controller'];
        $this->method = AVAILABLE_ROUTES[$page]['method'];


    }

    public function getController(): void
    {
        
        $instance = "Controllers\\" . $this->controller;

        $controller = new $instance();
        $method = $this->method;

        $controller->$method();
    }
}