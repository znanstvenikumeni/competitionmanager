<?php

$request = $_SERVER['REQUEST_URI'];
$route = explode('/', $request);
$route = array_splice($route, 1);
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    header('Access-Control-Allow-Origin: '.$config->vmssBaseURL);
    die();
}
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
    case 'public':
    	if($config->publicAccessEnabled != true){
	    	$Session = new Session($pdo);
	        $Session->token = $_COOKIE['cmsession'];
	        if(!$Session->verify()){
	                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
	                header('Location: /accounts/signin');
	                die();
	        }
	        $User = new User($pdo);
	        $User->id = $Session->user;
	        $User->load();
 			if(stripos($User->aai,"@".$config->adminDomain) != strlen($User->aai)-strlen('@'.$config->adminDomain)){	            header('Location: /dashboard'); die();
	        }
    	}
    	if(!isset($route[1])){
    		$ApplicationFactory = new Application($pdo);
       			$Applications = $ApplicationFactory->byMentor('');
       			foreach($Applications as &$Application){
       				$Application->mentors = json_decode($Application->mentors);
       				foreach($Application->mentors as &$Mentor){
       					$Mentor->aai = 'ProtectedValue';
       				}
       				$Application->teamMembers = json_decode($Application->teamMembers);
       				foreach($Application->teamMembers as &$Member){
       					$MemberAAI = $Member->aai;
       					$MemberUser = new User($pdo);
       					$MemberUser->aai = $MemberAAI;
       					$MemberUser->load();
       					$Member->name = $MemberUser->firstName.' '.$MemberUser->lastName;
       					$Member->aai = 'ProtectedValue';
       					$Member->age = 'ProtectedValue';
       					$Member->zsem = 'ProtectedValue';
       				}
       			}
       			include '../views/public.php';
    	}
    	if(isset($route[1])){
    		switch ($route[1]) {
    			case 'account':
    				include '../views/account.php';
    				break;
    			case 'video':
    				$Application = new Application($pdo);
    				$Application->id = $route[2];
    				$Application->load();
    				include '../views/video.php';
    				break;
    			default:
    				# code...
    				break;
    		}
    	} 
    break;
    case 'indexWorker':
    	if(($route[1] ?? null) != $config->indexWorkerToken) die(':(');
		$Algolia = Algolia\AlgoliaSearch\SearchClient::create(
		  $keys->algoliaKeyPublic,
		  $keys->algoliaKeyPrivate
		);

		$index = $Algolia->initIndex($config->algoliaIndex);
		$ApplicationFactory = new Application($pdo);
		$Applications = $ApplicationFactory->byMentor('');
		foreach($Applications as &$Application){
			$Application->mentors = json_decode($Application->mentors);
			foreach($Application->mentors as &$Mentor){
				$Mentor->aai = 'ProtectedValue';
			}
			$Application->teamMembers = json_decode($Application->teamMembers);
			foreach($Application->teamMembers as &$Member){
				$MemberAAI = $Member->aai;
				$MemberUser = new User($pdo);
				$MemberUser->aai = $MemberAAI;
				$MemberUser->load();
				$Member->name = $MemberUser->firstName.' '.$MemberUser->lastName;
				$Member->aai = 'ProtectedValue';
				$Member->age = 'ProtectedValue';
				$Member->zsem = 'ProtectedValue';
			}
		}
		foreach($Applications as &$App){
			$App = (array)$App;
		}
		$index->saveObjects((array)$Applications, ['objectIDKey' => 'id']);
	break;
    case 'publicAPI':
    	$APIRequest = new APIRequest($pdo, array_splice($route, 1));
    	$APIRequest->handle();
    break;
    case 'getUploadEndpoint':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                header('Location: /accounts/signin');
                die();
        }
        $Token = new Token($pdo, $route[1]);
        $Token->load();
        if($Token->used){
            new LogEntry($pdo, 'TokenSecurity/TokenIdempotency', 'getUploadEndpoint', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        if($Token->usableOn != 'getUploadEndpoint'){
            new LogEntry($pdo, 'TokenSecurity/TokenSpecificValidity', 'getUploadEndpoint', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        $Token->used();
        $EndpointURL = file_get_contents($config->vmssAuthEndpoint);
        var_dump($config->vmssBaseURL.$EndpointURL);
    break;

    case 'dashboard':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                header('Location: /accounts/signin');
                die();
        }
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();
        if($User->isMentor()){
            header('Location: /mentorpanel');
            die();
        }

        $Application = new Application($pdo);
        $Applications = $Application->byUser($Session->user);
        if(count($Applications) == 0){
            $Applications = $Application->byUser($Session->aai);
        }
        

        
        include '../views/dashboard.php';
    break;
    case 'mentorpanel':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                header('Location: /accounts/signin');
                die();
        }
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();
        $Application = new Application($pdo);
        $Applications = $Application->byMentor($Session->user);
        $Applications2 = $Application->byMentor($User->aai);
        $Applications = array_merge($Applications, $Applications2);
        unset($Applications2);
        include '../views/mentorpanel.php';
    break;
    case 'organiserpanel':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                header('Location: /accounts/signin');
                die();
        }
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();
        if(stripos($User->aai,"@".$config->adminDomain) != strlen($User->aai)-strlen('@'.$config->adminDomain)){
            header('Location: /dashboard'); die();
        }
        $Application = new Application($pdo);
        $Applications = $Application->byMentor('');
        $Applications2 = $Application->byMentor($Session->aai);
        array_merge($Applications, $Applications2);

        unset($Applications2);
        include '../views/organiserpanel.php';
    break;
    case 'suglasnost':
        header('Location: https://znanstvenikumeni.org/obrazac-za-suglasnost/');
        die();
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
        elseif($route[1] == 'signout'){
            $Session = new Session($pdo);
            $Session->token = '-1';
            $Session->validity = 1;
            $Session->config = $config;
            $Session->setCookie();
            header('Location: /');
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
            die();
        }
        $Session = new Session($pdo);
        $Session->config = $config;
        $Session->user = $User->id;
        $Session->create();
        $Session->setCookie();
        header('Location: /dashboard');
    break;
    case 'preferences':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                header('Location: /accounts/signin');
                die();
        }
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();
        $Token = new Token($pdo,null,$User->id,$Session->id,'editPreferences');
        $formtoken = $Token->get();
        include '../views/preferences.php';
    break;
    case 'editPreferences':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
            new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
            header('Location: /accounts/signin');
            die();
        }
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();

        $Token = new Token($pdo, $_POST['csrftoken']);
        $Token->load();
        if($Token->used){
            new LogEntry($pdo, 'TokenSecurity/TokenIdempotency', 'editPreferences', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        if($Token->usableOn != 'editPreferences'){
            new LogEntry($pdo, 'TokenSecurity/TokenSpecificValidity', 'editPreferences', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        $Token->used();
        $User->newUser = 0;
        $User->firstName = $_POST['firstName'];
        $User->lastName = $_POST['lastName'];
        $User->email = $_POST['email'];
        $User->phone = $_POST['phone'];
        $User->save();
        header('Location: /');
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
            new LogEntry($pdo, 'TokenSecurity/TokenSpecificValidity', 'addUser', 'failed',null, null, null);
            throw new Exception('CSRF validation failed');
        }
        $Token2->used();
        $User->aai = $_POST['aai'];
        if(stripos($User->aai, '@skole.hr') === FALSE){
            include '../views/errors/invalidData.php';
            throw new Exception('Invalid data entered');
            die();
        }
        if(stripos($User->aai, $config->adminDomain) !== FALSE){
        	throw new Exception('Attack vector detected');
        	die();
        }
        $User->password = $_POST['password']; // it gets hashed in User.php and doesn't get saved in plaintext, don't worry
        if(strlen($User->password) < 8){
            include '../views/errors/invalidData.php';
            throw new Exception('Invalid data entered');
            die();
        }
        if(!preg_match("/[^a-zA-Z]{1,}/", $User->password)){
            include '../views/errors/invalidData.php';
            throw new Exception('Invalid data entered');
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
            throw new Exception('Invalid data entered - password too common');
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
    
    case 'application':
        if($route[1] == 'new'){
            $Session = new Session($pdo);
            $Session->token = $_COOKIE['cmsession'];
            if(!$Session->verify()){
                    new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                    header('Location: /accounts/signin');
                    die();
            }
            $User = new User($pdo);
            $User->id = $Session->user;
            $User->load();
            $Token = new Token($pdo,null,$User->id,$Session->id,'addApplication');
            $formtoken = $Token->get();
            $EndpointURL = file_get_contents($config->vmssAuthEndpoint);
            $EndpointURL = $config->vmssBaseURL.$EndpointURL;
            include '../views/newApplication.php';
        }
        else{
            $Session = new Session($pdo);
            $Session->token = $_COOKIE['cmsession'];
            if(!$Session->verify()){
                    new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                    header('Location: /accounts/signin');
                    die();
            }
            $User = new User($pdo);
            $User->id = $Session->user;
            $User->load();
            $ApplicationFactory = new Application($pdo);
            $Applications = $ApplicationFactory->byUser($User->id);
            $valid = false;
            foreach ($Applications as $App){
                if($App->id == $route[1]) $valid = true;
            }
            $Applications = $ApplicationFactory->byUser($User->aai);
            foreach ($Applications as $App){
                if($App->id == $route[1]) $valid = true;
            }
            if(!$valid){
                new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                header('Location: /accounts/signin');
                die();
            }
            $Application = new Application($pdo);
            $Application->id = $route[1];
            $Application->load();
            if($Application->status != 1){
                new LogEntry($pdo, 'ApplicationIntegrity/ApplicationStatusHigherThan1TryingToBeEdited', 'application/id', 'failed',$_POST, $Session->user, $_COOKIE['cmsession']);
                die();
            }
            $Token = new Token($pdo,null,$User->id,$Session->id,'editApplication');
            $formtoken = $Token->get();
            $EndpointURL = file_get_contents($config->vmssAuthEndpoint);
            $EndpointURL = $config->vmssBaseURL.$EndpointURL;
            include '../views/editApplication.php';
        }
    break;
    case 'editApplication':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
            new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
            header('Location: /accounts/signin');
            die();
        }
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();

        $Token = new Token($pdo, $_POST['csrftoken']);
        $Token->load();
        if($Token->used){
            new LogEntry($pdo, 'TokenSecurity/TokenIdempotency', 'editApplication', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        if($Token->usableOn != 'editApplication'){
            new LogEntry($pdo, 'TokenSecurity/TokenSpecificValidity', 'editApplication', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        $Token->used();
        $ApplicationFactory = new Application($pdo);
        $Applications = $ApplicationFactory->byUser($User->id);
        $valid = false;
        foreach ($Applications as $App){
            if($App->id == $_POST['applicationID']) $valid = true;
        }
        $Applications = $ApplicationFactory->byUser($User->aai);
        foreach ($Applications as $App){
            if($App->id == $_POST['applicationID']) $valid = true;
        }
        if(!$valid){
            new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
            header('Location: /accounts/signin');
            die();
        }
        $Application = new Application($pdo);
        $Application->id = $_POST['applicationID'];
        $Application->load();
        if($Application->status != 1){
            new LogEntry($pdo, 'ApplicationIntegrity/ApplicationStatusHigherThan1TryingToBeEdited', 'editApplication', 'failed',$_POST, $Session->user, $_COOKIE['cmsession']);
            die();
        }
        $Application->title = $_POST['title'];
        $Application->description = $_POST['description'];
        $Application->vmssID = $_POST['vmssid'];
        
        $TeamMembers['carrier']['aai'] = $_POST['aai1'];
        $TeamMembers['carrier']['school'] = $_POST['school1'];
        $TeamMembers['carrier']['age'] = $_POST['age1'];
        $TeamMembers['carrier']['zsem'] = $_POST['zsem1'];
        if(!($_POST['aai1'] && $_POST['school1'] && $_POST['age1'])){
            $TeamMembersMissingData = true;
        }
        
        $Competitor = new User($pdo);
        $Competitor->aai = $_POST['aai1'];
        $Competitor->load();
        $TeamMembers['carrier']['id'] = $Competitor->id;
        if($_POST['aai2']){
            $Competitor = new User($pdo);
            $Competitor->aai = $_POST['aai2'];
            $Competitor->load();
            $TeamMembers['secondary']['aai'] = $_POST['aai2'];
            $TeamMembers['secondary']['id'] = $Competitor->id;
            $TeamMembers['secondary']['school'] = $_POST['school2'];
            $TeamMembers['secondary']['age'] = $_POST['age2'];
            $TeamMembers['secondary']['zsem'] = $_POST['zsem2'];
            if($Competitor->id) $TeamMembersValid = true;
            else $TeamMembersValid = false;
            if(!($_POST['aai2'] && $_POST['school2'] && $_POST['age2'])){
                $TeamMembersMissingData = true;
            }
        }
        else{
            $TeamMembersValid = true;
        }

        $Mentor = new User($pdo);
        $Mentor->aai = $_POST['aaiMentor1'];
        $Mentors['first']['aai'] = $Mentor->aai;
        $Mentor->load();
        $Mentors['first']['name'] = $Mentor->firstName.' '.$Mentor->lastName;
        if($Mentor->id) $MentorsValid = true;
        else $MentorsValid = false;
        if($_POST['aaiMentor2']){
            $Mentor = new User($pdo);
            $Mentor->aai = $_POST['aaiMentor1'];
            $Mentors['second']['aai'] = $Mentor->aai;
            $Mentor->load();
            $Mentors['second']['name'] = $Mentor->firstName.' '.$Mentor->lastName;
            if($Mentor->id) $MentorsValid = true;
            else $MentorsValid = false;
        }
        
        $TeamMembers = json_encode($TeamMembers);
        $Mentors = json_encode($Mentors);
        $Year = $config->organisationalYear;
        $Data['category'] = $_POST['category'];
        $CategoryValid = (bool)$_POST['category'];
        $Data = json_encode($Data);
        $Application->mentors = $Mentors;
        $Application->teamMembers = $TeamMembers;
        $Application->year = $Year;
        $Application->data = $Data;
        if($_POST['draft']){
            $status = 1;
        }
        else{
            $status = 2;
        }
        if($status == 2){
            $errors = [];
            if(!$Application->title){
                $errors[] = 'Niste unijeli Naslov rada, što je obavezno polje.';
            }
            if(!$Application->description){
                $errors[] = 'Niste unijeli Opis rada, što je obavezno polje.';
            }
            if(!$Application->vmssID){
                $errors[] = 'Niste prenijeli videozapis rada, što je obavezno.';
            }
            if(!$CategoryValid){
                $errors[] = 'Niste unijeli Kategoriju rada, što je obavezno polje.';
            }
            if(!$TeamMembersValid){
                $errors[] = 'Netko od natjecatelja koji su članovi rada nema otvoren korisnički račun, što je obavezno.';
            }
            if($TeamMembersMissingData){
                $errors[] = 'Neki podaci o natjecateljima nedostaju.';
            }
            if(!$MentorsValid){
                $errors[] = 'Netko od mentora rada nema otvoren korisnički račun, što je obavezno';
            }
            if(count($errors)){
                $status = 1;
            }
        }
        $Application->status = $status;
        $Application->save();
        if(count($errors)){
            include '../views/applicationSubmissionError.php';
        }
        elseif($status==2){
            $EmailData['date'] = date('j. n. Y.');
            $i=0;
            $AppDetails[$i]['field'] = 'Naslov rada';
            $AppDetails[$i]['content'] = $Application->title;
            $i++;
            $AppDetails[$i]['field'] = 'Opis rada';
            $AppDetails[$i]['content'] = $Application->description;
            $i++;
            $AppDetails[$i]['field'] = 'Oznaka kategorije';
            $AppDetails[$i]['content'] = $_POST['category'];
            $i++;
            $AppDetails[$i]['field'] = 'ID videozapisa';
            $AppDetails[$i]['content'] = $Application->vmssID;
            $i++;
            $EmailData['app_details'] = $AppDetails;
            $sendResult = $Postmark->sendEmailWithTemplate(
            $config->defaultEmail,
            $User->email,
            $config->postmarkApplicationSubmissionTemplate,
            $EmailData);
            header('Location: /dashboard');
        }
        else{
            header('Location: /dashboard');
        }
    break;
    case 'addApplication':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
            new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
            header('Location: /accounts/signin');
            die();
        }
        $User = new User($pdo);
        $User->id = $Session->user;
        $User->load();

        $Token = new Token($pdo, $_POST['csrftoken']);
        $Token->load();
        if($Token->used){
            new LogEntry($pdo, 'TokenSecurity/TokenIdempotency', 'addApplication', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        if($Token->usableOn != 'addApplication'){
            new LogEntry($pdo, 'TokenSecurity/TokenSpecificValidity', 'addApplication', 'failed',null, $Session->id, $User->id);
            throw new Exception('CSRF validation failed');
        }
        $Token->used();
        if($_POST['status'] != "1"){
            new LogEntry($pdo, 'ApplicationIntegrity/ApplicationStatusHigherThan1OnNewApplication', 'addApplication', 'success', json_encode([$_POST['title'], $_POST['vmssid']]));
        }
        $TeamMembers['carrier']['id'] = $User->id;
        $TeamMembers['carrier']['aai'] = $User->aai;
        $TeamMembers['carrier']['school'] = $_POST['school1'];
        $TeamMembers['carrier']['age'] = $_POST['age1'];
        $TeamMembers['carrier']['zsem'] = $_POST['zsem1'];
        if($_POST['aai2']){
            $Competitor2 = new User($pdo);
            $Competitor2->aai = $_POST['aai2'];
            $TeamMembers['secondary']['aai'] = $Competitor2->aai;
            $Competitor2->load();
        
       
            $TeamMembers['secondary']['id'] = $Competitor2->id;
            if(!$Competitor2->firstName){
                $sendResult = $Postmark->sendEmailWithTemplate(
                $config->defaultEmail,
                $_POST['aai2'],
                $config->postmarkInviteTemplate,
                [
                "name1" => $User->firstName.' '.$User->lastName,
                "action_url" => $config->signupURL
                ]);
            }
        }
        $Mentor1 = new User($pdo);
        $Mentor1->aai = $_POST['aaiMentor1'];
        if($Mentor1->aai){
            $Mentor1->load();
            if(!$Mentor1->firstName){
                $sendResult = $Postmark->sendEmailWithTemplate(
                $config->defaultEmail,
                $_POST['aaiMentor1'],
                $config->postmarkInviteTemplate,
                [
                "name1" => $User->firstName.' '.$User->lastName,
                "action_url" => $config->signupURL
                ]);
            }
        }
        
        $Mentors['first']['id'] = $Mentor1->id;
        $Mentors['first']['aai'] = $Mentor1->aai;
        $Mentor2 = new User($pdo);
        $Mentor2->aai = $_POST['aaiMentor2'];
        if($Mentor2->aai){
            $Mentor2->load();
            if(!$Mentor2->firstName){
                $sendResult = $Postmark->sendEmailWithTemplate(
                $config->defaultEmail,
                $_POST['aaiMentor2'],
                $config->postmarkInviteTemplate,
                [
                "name1" => $User->firstName.' '.$User->lastName,
                "action_url" => $config->signupURL
                ]);
            }
            $Mentors['secondary']['id'] = $Mentor2->id;
            $Mentors['secondary']['aai'] = $Mentor2->aai;
        }
        $Application = new Application($pdo);
        $Application->title = $_POST['title'];
        $Application->description = $_POST['description'];
        $Application->vmssID = $_POST['vmssid'];
        $Application->mentors = json_encode($Mentors);
        $Application->teamMembers = json_encode($TeamMembers);
        $Application->status = 1;
        $Application->year = $config->organisationalYear;
        $Data['category'] = $_POST['category'];
        $Application->data = json_encode($Data);
        $Application->save();
        header('Location: /dashboard');
    break;
    case 'accountAPI':
        $Session = new Session($pdo);
        $Session->token = $_COOKIE['cmsession'];
        if(!$Session->verify()){
                    new LogEntry($pdo, 'SessionSecurity', 'SessionValidationForProtectedPage', 'failed',null, $Session->user, $_COOKIE['cmsession']);
                    header('Location: /accounts/signin');
                    die();
        }
        $User = new User($pdo);
        $User->aai = $route[1];
        $User->load();
        $publicData['name'] = $User->firstName.' '.$User->lastName;
        echo json_encode($publicData);
    break;
    default:
        include '../views/errors/404.php';
    break;
}
