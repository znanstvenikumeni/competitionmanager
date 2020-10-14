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

    public function checkAttempts(){
        $query = "SELECT * FROM logs WHERE component = 'AccountSecurity/LoginFail/AccountDoesntExist' AND time>:time AND ip=:ip";
        $params['time'] = time()-60*30;
        $params['ip'] = $_SERVER['REMOTE_ADDR'];
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $attemptsQ1 = $statement->fetchAll(PDO::FETCH_ASSOC);
        $failedAttemptsByIP = count($attemptsQ1);
        $query = "SELECT * FROM logs WHERE component = 'AccountSecurity/LoginFail/WrongPassword' AND time>:time AND ip=:ip";
        $params['time'] = time()-60*30;
        $params['ip'] = $_SERVER['REMOTE_ADDR'];
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $attemptsQ2 = $statement->fetchAll(PDO::FETCH_ASSOC);
        $failedAttemptsByIP += count($attemptsQ2);
        $query = "SELECT * FROM logs WHERE component = 'AccountSecurity/LoginFail/WrongPassword' AND time>:time AND user=:user";
        $params2['time'] = time()-60*30;
        $params2['user'] = $this->user;
        $statement = $this->conn->prepare($query);
        $statement->execute($params2);
        $attemptsQ3 = $statement->fetchAll(PDO::FETCH_ASSOC);
        $failedAttemptsByUser = count($attemptsQ3);
        if($failedAttemptsByIP > 5 && $failedAttemptsByUser < 5){
            return -1;
        }
        if($failedAttemptsByIP > 5 && $failedAttemptsByUser >= 5){
            return -2;
        }
        if($failedAttemptsByIP + $failedAttemptsByUser > 5){
            return -3;
        }

    }

    public function create(){
        $allow = $this->checkAttempts();
        if($allow < 0){
            new LogEntry($this->conn, 'AccountSecurity/LoginFail/WrongPassword', 'addSession', 'failed',null, $this->aai, null);
            header('Location: /accounts/signin/tooManyAttempts');
            die();
        }
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
    public function load(){
        $query = "SELECT * FROM sessions WHERE token=:token";
        $params['token'] = $this->token;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $token = $statement->fetch(PDO::FETCH_ASSOC);
        foreach($token as $key=>$value){
            $this->$key = $value;
        }
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