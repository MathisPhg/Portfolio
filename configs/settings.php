<?php

const AVAILABLE_ROUTES = [
    'home' => [
        'controller' => 'HomeController',
        'method' => 'index'
    ],
    'project' => [
        'controller' => 'ProjectController',
        'method' => 'index'
    ],
    'login' => [
        'controller' => 'LoginController',
        'method' => 'index'
    ],
    'dashboard' => [
        'controller' => 'DashboardController',
        'method' => 'index'
    ],
    'list' => [
        'controller' => 'ListController',
        'method' => 'index'
    ],
    'create' => [
        'controller' => 'CreateController',
        'method' => 'index'
    ],
    'edit' => [
        'controller' => 'EditController',
        'method' => 'index'
    ],
    '404' => [
        'controller' => 'ErrorController',
        'method' => 'index'
    ],
];