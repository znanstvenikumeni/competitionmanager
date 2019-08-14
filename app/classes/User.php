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

}