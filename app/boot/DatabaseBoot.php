<?php

$connectionString = $config->database->type.':host='.$config->database->host.';dbname='.$config->database->database.';charset=utf8';
try{
    $pdo = new PDO($connectionString, $config->database->user, $config->database->password);
} catch (Exception $exception)
{
    throw new Exception('Database connection error: '.$exception);
}
