<?php
class Application{
    private $conn;

    public $id;
    public $title;
    public $description;
    public $vmssID;
    public $mentors;
    public $teamMembers;
    public $status;
    public $year;
    public $data;
    public $pdf;

    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }

    public function byUser($user){
        $query = "SELECT * FROM applications WHERE teamMembers LIKE concat('%', :user, '%') ORDER BY year DESC";
        $params['user'] = $user;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $application = $statement->fetchAll(PDO::FETCH_ASSOC);
        $Applications = [];
        foreach($application as $row){
            $App = new Application($this->conn);
            foreach($row as $key=>$value){
                $App->$key = $value;
            }
            array_push($Applications, $App);
        }
        
        return $Applications;
    }
    
    public function byMentor($mentor){
        $query = "SELECT * FROM applications WHERE mentors LIKE concat('%', :mentor, '%') ORDER BY year DESC";
        $params['mentor'] = $mentor;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $application = $statement->fetchAll(PDO::FETCH_ASSOC);
        $Applications = [];
        foreach($application as $row){
            $App = new Application($this->conn);
            foreach($row as $key=>$value){
                $App->$key = $value;
            }
            array_push($Applications, $App);
        }
        
        return $Applications;
    }
    public function fetchAll(){
        $query = "SELECT * FROM applications ORDER BY id DESC";
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $application = $statement->fetchAll(PDO::FETCH_ASSOC);
        $Applications = [];
        foreach($application as $row){
            $App = new Application($this->conn);
            foreach($row as $key=>$value){
                $App->$key = $value;
            }
            array_push($Applications, $App);
        }

        return $Applications;
    }
    public function byYear($year){
        $query = "SELECT * FROM applications WHERE year = :year";
        $params['year'] = $year;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $application = $statement->fetchAll(PDO::FETCH_ASSOC);
        $Applications = [];
        foreach($application as $row){
            $App = new Application($this->conn);
            foreach($row as $key=>$value){
                $App->$key = $value;
            }
            array_push($Applications, $App);
        }

        return $Applications;
    }


    private function prepareData(){
        if($this->id){
            $params['id'] = $this->id;
        }
        if(!$this->data) {
            $this->data = new \stdClass();
        }
        $params['title'] = $this->title;
        $params['description'] = $this->description;
        $params['vmssID'] = $this->vmssID;
        $params['mentors'] = $this->mentors;
        $params['teamMembers'] = $this->teamMembers;
        $params['status'] = $this->status;
        $params['year'] = $this->year;
        $this->data->pdf = $this->pdf;
        $params['data'] = json_encode($this->data);
        return $params;
    }

    public function save(){
        if($this->id){
            $this->saveAsUpdate();
        }
        else{
            $this->saveAsNewApplication();
        }
    }

    private function saveAsUpdate(){
        $params = $this->prepareData();
        $sqlQuery = "UPDATE applications SET title=:title, description=:description, vmssID=:vmssID, mentors=:mentors, teamMembers=:teamMembers, status=:status, year=:year, data=:data WHERE id=:id";
        $statement = $this->conn->prepare($sqlQuery);
        $statement->execute($params);
        return $this->id;
    }
    private function saveAsNewApplication(){
        $params = $this->prepareData();
        $sqlQuery = "INSERT INTO applications VALUES (null, :title, :description, :vmssID, :mentors, :teamMembers, :status, :year, :data)";
        $statement = $this->conn->prepare($sqlQuery);
        $statement->execute($params);
        $this->id = $this->conn->lastInsertId();
    }

    public function load(){
        $sqlQuery = "SELECT * FROM applications WHERE id=:id";
        $params['id'] = $this->id;
        $statement = $this->conn->prepare($sqlQuery);
        $statement->execute($params);
        $Application = $statement->fetch(PDO::FETCH_ASSOC);
        $this->loadFromAssoc($Application);
    }

    private function loadFromAssoc($assoc){
        foreach($assoc as $key=>$value){
            $this->$key = $value;
        }
        $this->data = json_decode($this->data);
        $this->pdf = $this->data->pdf ?? null;
    }
}
