<?php

$request = $_SERVER['REQUEST_URI'];
$route = explode('/', $request);
$route = array_splice($route, 1);

switch($route[0]){
    case '':
        if(isset($_COOKIE['cmsession'])){
            $Session = new Session($pdo);
            $Session->token = $_COOKIE['cmsession'];
            if(!$Session->verify()){
                header('Location: /accounts/signin');
                die();
            }
            else{
                header('Location: /dashboard');
                die();
            }
        }
        else{
            header('Location: /accounts/signin');
            die();
        }
    break;

    case 'dashboard':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                header('Location: /accounts/signin');
                die();
        }
        $Application = new Application($pdo);
        $Applications = $Application->byUser($Session->user);
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();
        include '../views/dashboard.php';
    break;
    case 'accounts':
        if($route[1] == 'new'){
            $Token = new Token($pdo,null,null,null,'addUser');
            $formtoken = $Token->get();
           
            include '../views/signup.php';
        }
        elseif($route[1] == 'signin'){
            $Token = new Token($pdo,null,null,null,'addSession');
            $formtoken = $Token->get();
            if(isset($route[2])){
                if($route[2] == 'error'){
                    $msg = '<div class="alert alert-danger"><b>Pogrešan AAI@EduHR identitet ili lozinka.</b> Pokušajte ponovno ili se obratite Organizaciji natjecanja za pomoć.</div>';
                }
                if($route[2] == 'tooManyAttempts'){
                    $msg = '<div class="alert alert-danger"><b>Sigurnosno blokiranje aktivno.</b> Vaš korisnički račun i/ili IP adresa su blokirani na pola sata zbog prevelikog broja neuspjelih prijava. Dodatni pokušaji prijava produžit će vrijeme čekanja na otključavanje korisničkog računa. Za pomoć, obratite se Organizaciji natjecanja.</div>';
                }
            }
            
            include '../views/signin.php';
        }
    break;
    case 'addSession':
        $User = new User($pdo);
        $Token2 = new Token($pdo, $_POST['csrftoken']);
        $Token2->load();
        if($Token2->used){
            new LogEntry($pdo, 'TokenSecurity/TokenIdempotency', 'addSession', 'failed',null, null, null);
            throw new Exception('CSRF validation failed');
        }
        if($Token2->usableOn != 'addSession'){
            new LogEntry($pdo, 'TokenSecurity/TokenSpecificValidity', 'addSession', 'failed',null, null, null);
            throw new Exception('CSRF validation failed');
        }
        $Token2->used();
        $User->aai = $_POST['aai'];
        $User->load();
        if($User->password == null){
            new LogEntry($pdo, 'AccountSecurity/LoginFail/AccountDoesntExist', 'addSession', 'failed',null, $_POST['aai'], null);
            header('Location: /accounts/signin/error');
            die();
        }
        if(!(password_verify($_POST['password'], $User->password))){
            new LogEntry($pdo, 'AccountSecurity/LoginFail/WrongPassword', 'addSession', 'failed',null, $_POST['aai'], null);
            header('Location: /accounts/signin/error');
        }
        $Session = new Session($pdo);
        $Session->config = $config;
        $Session->user = $User->id;
        $Session->create();
        $Session->setCookie();
        header('Location: /dashboard');
    break;
    case 'addUser':
        $User = new User($pdo);
        $Token2 = new Token($pdo, $_POST['csrftoken']);
        $Token2->load();
        if($Token2->used){
            new LogEntry($pdo, 'TokenSecurity/TokenIdempotency', 'addUser', 'failed',null, null, null);
            throw new Exception('CSRF validation failed');
        }
        if($Token2->usableOn != 'addUser'){
            new LogEntry($pdo, 'TokenSecurity/TokenSpecificValidity', 'addSession', 'failed',null, null, null);
            throw new Exception('CSRF validation failed');
        }
        $Token2->used();
        $User->aai = $_POST['aai'];
        if(stripos($User->aai, '@skole.hr') === FALSE){
            include '../views/errors/invalidData.php';
            //throw new Exception('Invalid data entered');
            die();
        }
        $User->password = $_POST['password']; // it gets hashed in User.php and doesn't get saved in plaintext, don't worry
        if(strlen($User->password) < 8){
            include '../views/errors/invalidData.php';
            //throw new Exception('Invalid data entered');
            die();
        }
        $blacklist = file_get_contents('../passwordsBlacklist.txt');
        $blacklist = explode("\r\n", $blacklist);

        $blacklisted = false;
        $flipped_haystack = array_flip($blacklist);
        if ( isset($flipped_haystack[$User->password]) ){
            $blacklisted = true;
        } 
        if($blacklisted){
            include '../views/errors/invalidData.php';
            //throw new Exception('Invalid data entered - password too common');
            die();
        }
        $User->firstName = $_POST['firstName'];
        $User->lastName = $_POST['lastName'];
        $metadata['type'] = $_POST['type'];
        $User->metadata = json_encode($metadata);
        $User->email = $_POST['email'];
        $User->phone = $_POST['phone'];
        $User->newUser = 1;
        $User->save();
        $Session = new Session($pdo);
        $Session->config = $config;
        $Session->user = $User->id;
        $Session->create();
        $Session->setCookie();
        header('Location: /dashboard');
    break;
    
    default:
        include '../views/errors/404.php';
    break;
}