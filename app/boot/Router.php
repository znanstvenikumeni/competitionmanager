<?php

$request = $_SERVER['REQUEST_URI'];
$route = explode('/', $request);
$route = array_splice($route, 1);

switch($route[0]){
    case '':

    break;

    case 'accounts':
        if($route[1] == 'new'){
            $Token = new Token($pdo,null,null,null,'addUser');
            $formtoken = $Token->get();
            include '../views/signup.php';
        }
    break;
    case 'addUser':

        echo 1;
        $User = new User($pdo);
        if(stripos($User->aai, '@skole.hr') === FALSE){
            throw new Exception('Invalid data entered');
        }
        $User->aai = 'test@znanstvenikumeni.org';
        $User->password = 'test';
        $User->firstName = 'Test';
        $User->lastName = 'User';
        $User->metadata = '-';
        $User->email = 'test@znanstvenikumeni.org';
        $User->phone = '123456789';
        $User->newUser = 1;
        $User->save();
    break;
    
    default:
        include '../views/errors/404.php';
    break;
}