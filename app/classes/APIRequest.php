<?php
class APIRequest{
	private $conn;
	private $route;
	private $config;

	public function __construct(\PDO $pdo, $route) {
        $this->conn = $pdo;
        $this->route = $route;
        include __DIR__.'/../boot/ConfigBoot.php';
        $this->config = $config;
    }

    public function handle(){
    	$this->routeRequest();
    }
    private function sendErrorResponse($message, $code){
    	$error['code'] = $code;
    	header('Content-Type: application/json');
    	http_response_code($code);
    	$error['message'] = $message;
    	echo json_encode($error);
    	die();
    }
    private function serve($Output, $code){
    	http_response_code($code);
    	header('Content-Type: application/json');
    	echo $Output;
    }
    private function routeRequest(){
    	ini_set('xdebug.var_display_max_depth', -1);
    	ini_set('xdebug.var_display_max_children', -1);
    	ini_set('xdebug.var_display_max_data', -1);
    	switch ($this->route[0] ?? null) {
    		case 'getApplicationSummary':
    			$ApplicationFactory = new Application($this->conn);
       			$Applications = $ApplicationFactory->byMentor('');
       			foreach($Applications as &$Application){
       				$Application->mentors = json_decode($Application->mentors);
       				foreach($Application->mentors as &$Mentor){
       					$Mentor->aai = 'ProtectedValue';
       				}
       				$Application->teamMembers = json_decode($Application->teamMembers);
       				foreach($Application->teamMembers as &$Member){
       					$MemberAAI = $Member->aai;
       					$MemberUser = new User($this->conn);
       					$MemberUser->aai = $MemberAAI;
       					$MemberUser->load();
       					$Member->name = $MemberUser->firstName.' '.$MemberUser->lastName;
       					$Member->aai = 'ProtectedValue';
       					$Member->age = 'ProtectedValue';
       					$Member->zsem = 'ProtectedValue';
       				}
       			}
       			$Output = json_encode($Applications);
       			$this->serve($Output, 200);
    			break;
    		case 'getApplication':
    			$ApplicationFactory = new Application($this->conn);
    			if(!isset($this->route[1])){
       				$this->sendErrorResponse('Bad Request: Application id not set', 400);
       			}
       			$ApplicationFactory->id = $this->route[1];
       			$ApplicationFactory->load();
     			$Applications[0] = $ApplicationFactory;
       			foreach($Applications as &$Application){
       				$Application->mentors = json_decode($Application->mentors);
       				foreach($Application->mentors as &$Mentor){
       					$Mentor->aai = 'ProtectedValue';
       				}
       				$Application->teamMembers = json_decode($Application->teamMembers);
       				foreach($Application->teamMembers as &$Member){
       					$MemberAAI = $Member->aai;
       					$MemberUser = new User($this->conn);
       					$MemberUser->aai = $MemberAAI;
       					$MemberUser->load();
       					$Member->name = $MemberUser->firstName.' '.$MemberUser->lastName;
       					$Member->aai = 'ProtectedValue';
       					$Member->age = 'ProtectedValue';
       					$Member->zsem = 'ProtectedValue';
       				}
       			}
       			$Output = json_encode($Applications);
       			$this->serve($Output, 200);
    			break;
            case 'getViewableApplications':
                $ApplicationFactory = new Application($this->conn);
                $Applications = $ApplicationFactory->fetchAll();
                foreach($Applications as $key=>&$Application){
                    if($Application->year > $this->config->lastOrganisationalYearToShowOnPublic) {
                        unset($Applications[$key]); continue;
                    }
                    if($Application->status != 2) {
                        unset($Applications[$key]); continue;
                    }
                    $Application->mentors = json_decode($Application->mentors);
                    foreach($Application->mentors as &$Mentor){
                        $Mentor->aai = 'ProtectedValue';
                    }
                    $Application->teamMembers = json_decode($Application->teamMembers);
                    foreach($Application->teamMembers as &$Member){
                        $Member->aai = 'ProtectedValue';
                        $Member->age = 'ProtectedValue';
                        $Member->zsem = 'ProtectedValue';
                    }
                }
                $Output = json_encode($Applications);
                $this->serve($Output, 200);
                break;
    		default:
    			$this->sendErrorResponse('Bad Request: Invalid route', 400);
    			break;
    	}
    }

}