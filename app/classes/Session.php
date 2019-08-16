<?php

class Session{
    private $conn;
    public $id;
    public $user;
    public $token;
    public $time;
    public $validity;
    public $ua;
    public $ip;
    public $data;
    public $config;

    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }

    public function create(){
        $this->token = bin2hex(openssl_random_pseudo_bytes(64));
        $this->time = time();
        $this->validity = time()+$this->config->defaultSessionValidity*60*60;
        $this->ua = $_SERVER['HTTP_USER_AGENT'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $query = "INSERT INTO sessions VALUES (null, :user, :token, :time, :validity, :useragent, :ip, :data)";
        $params['user'] = $this->user;
        $params['token'] = $this->token;
        $params['time'] = $this->time;
        $params['validity'] = $this->validity;
        $params['useragent'] = $this->ua;
        $params['ip'] = $this->ip;
        $params['data'] = $this->data;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
    }

    public function verify(){
        $query = "SELECT * FROM sessions WHERE token=:token";
        $params['token'] = $this->token;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $token = $statement->fetch(PDO::FETCH_ASSOC);
        foreach($token as $key=>$value){
            $this->$key = $value;
        }
        if($this->validity < time()) return false;
        return true;
    }
    public function setCookie(){
        setcookie('cmsession', $this->token, $this->validity, '/', $this->config->cookiedomain, $this->config->sslAvailable, true);  
    }
}