<?php

$request = $_SERVER['REQUEST_URI'];
$route = explode('/', $request);
$route = array_splice($route, 1);

switch($route[0]){
    case '':
    
    break;
    default:
        include '../views/errors/404.php';
    break;
}