<?php
error_reporting(E_ALL);
include 'ConfigBoot.php';
include '../app/handlers/ErrorHandler.php';
include '../vendor/autoload.php';
$bugsnag = Bugsnag\Client::make($keys->bugsnagKey);
Bugsnag\Handler::registerWithPrevious($bugsnag);
use Postmark\PostmarkClient;
$Postmark = new PostmarkClient($keys->postmarkKey);
include 'DatabaseBoot.php';
spl_autoload_register(function ($class_name) {
	if(file_exists('../app/classes/'.$class_name . '.php')) include '../app/classes/'.$class_name . '.php';
	if(file_exists('../app/requestHandlers/'.$class_name . '.php')) include '../app/requestHandlers/'.$class_name . '.php';
});
include 'Router.php';
