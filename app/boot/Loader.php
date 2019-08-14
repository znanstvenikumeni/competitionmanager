<?php
ini_set('display.errors', 1);
error_reporting(E_ALL);

include 'ConfigBoot.php';

include 'DatabaseBoot.php';
spl_autoload_register(function ($class_name) {
    include '../app/classes/'.$class_name . '.php';
});
include 'Router.php';
