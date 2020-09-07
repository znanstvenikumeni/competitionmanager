<?php
class User{
    private $conn;


    public $newUser;
    public $id;
    public $aai;
    public $password;
    public $passwordHash;
    public $firstName;
    public $lastName;
    public $metadata;
    public $email;
    public $phone;
    public $status;

    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }

    public function save(){
        if($this->newUser){
            return $this->saveNewUser();
        }
        else{
            return $this->updateUser();
        }
    }

    private function updateUser(){
        $params = $this->prepareData();
        $query = "UPDATE users SET aai=:aai, password=:password, firstName=:firstName, lastName=:lastName, metadata=:metadata, email=:email, phone=:phone, status=:status WHERE id=:id";
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
    }

    public function load(){
        if($this->aai){
            $query = "SELECT * FROM users WHERE aai=:aai LIMIT 1";
            $params['aai'] = $this->aai;
        }
        elseif($this->id){
            $query = "SELECT * FROM users WHERE id=:id LIMIT 1";
            $params['id'] = $this->id;
        }
        else{
            //throw new Exception('Called load() on User without setting aai or id');
            return null;
        }
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $this->id = $user['id'];
        $this->aai = $user['aai'];
        $this->password = $user['password'];
        $this->firstName = $user['firstname'];
        $this->lastName = $user['lastname'];
        $this->metadata = $user['metadata'];
        $this->email = $user['email'];
        $this->phone = $user['phone'];
        $this->status = $user['status'];

        $this->passwordHash = $this->password;

    }

    private function prepareData(){
        if(!$this->status){
            $this->status = 1;
        }
        if(!$this->aai || !($this->password || $this->passwordHash) || !$this->firstName || !$this->lastName){
            throw new Exception('Required data not set.');
        }
        $params = [];
        if(!$this->newUser){
            $params['id'] = $this->id;
        }
        else{
            $this->passwordHash = password_hash($this->password, PASSWORD_ARGON2ID);
        }
        $params['aai'] = $this->aai;
        $params['password'] = $this->passwordHash;
        $params['firstName'] = $this->firstName;
        $params['lastName'] = $this->lastName;
        $params['metadata'] = $this->metadata;
        $params['email'] = $this->email;
        $params['phone'] = $this->phone;
        $params['status'] = $this->status;
        return $params;
    }
    private function saveNewUser(){
        $params = $this->prepareData();
        $query = "INSERT INTO users VALUES (null, :aai, :password, :firstName, :lastName, :metadata, :email, :phone, :status)";
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $this->id = $this->conn->lastInsertId();
    }

    public function isMentor(){
        $Metadata = json_decode($this->metadata);
        if($Metadata->type == 2) return true;
        return false;
    }
    public function isJury(){
        $Metadata = json_decode($this->metadata);
        if($Metadata->type == 3) return true;
        return false;
    }

    public function searchByAAI($PartOfAAI){
        $query = "SELECT aai FROM users WHERE aai LIKE :aai";
        $statement = $this->conn->prepare($query);
        $params['aai'] = '%'.$PartOfAAI.'%';
        $statement->execute($params);
        $res = $statement->fetchAll(PDO::FETCH_ASSOC);
        $Users = [];

        foreach($res as $row){
            $User = new User($this->conn);
            $User->aai = $row['aai'];
            $User->load();
            $Users[] = $User;
        }
        return $Users;
    }

}