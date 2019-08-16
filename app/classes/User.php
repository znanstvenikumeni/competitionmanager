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

    public function load(){
        $query = "SELECT * FROM users WHERE aai=:aai LIMIT 1";
        $params['aai'] = $this->aai;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $this->id = $user['id'];
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


}