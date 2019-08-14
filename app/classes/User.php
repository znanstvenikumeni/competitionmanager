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
        echo 2;
        if($this->newUser){
            return $this->saveNewUser();
        }
        else{
            return $this->updateUser();
        }
    }

    private function prepareData(){
        echo 4;
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
        echo 3;
        $params = $this->prepareData();
        var_dump($params);
        $query = "INSERT INTO users VALUES (null, :aai, :password, :firstName, :lastName, :metadata, :email, :phone, :status)";
        try{
        $statement = $this->conn->prepare($query);
        }
        catch(Exception $e){
            var_dump($e);
        }
        try{
        $statement->execute($params);
        }
        catch(Exception $e){
            var_dump($e);
        }
        var_dump($statement, $this->conn, $params, $this->conn->errorInfo());
    }


}