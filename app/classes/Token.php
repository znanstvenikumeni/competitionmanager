<?php
class Token{
    private $conn;
    private $token;
    private $user;
    private $session;
    private $used;
    private $usableOn;
    private $data;

    public function __construct(\PDO $pdo, $token = null, $user=null, $session=null, $usableOn=null) {
        $this->conn = $pdo;
        $this->token = $token;
        $this->user = $user;

        $this->session = $session;
        $this->usableOn = $usableOn;
    }

    public function get(){
        if(!$this->token){
            $this->set();
            $this->insert();
        }
        return $token;
    }
    private function set(){
        $this->token = bin2hex(openssl_random_pseudo_bytes(64));
    }
    private function insert(){
        $query = "INSERT INTO tokens VALUES (null, :user, :session, :token, :used, :usableOn, :data)";
        $params['user'] = $this->user;
        $params['session'] = $this->session;
        $params['token'] = $this->token;
        $params['used'] = $this->used;
        $params['usableOn'] = $this->usableOn;
        $params['data'] = $this->data;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
    }
}