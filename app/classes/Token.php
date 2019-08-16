<?php
class Token{
    private $conn;
    public $token;
    public $user;
    public $session;
    public $used;
    public $usableOn;
    public $data;

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
        return $this->token;
    }
    public function load(){
        $query = "SELECT * FROM tokens WHERE token=:token LIMIT 1";
        $params['token'] = $this->token;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $token = $statement->fetch(PDO::FETCH_ASSOC);
        $this->user = $token['user'];
        $this->session = $token['session'];
        $this->used = $token['used'];
        $this->usableOn = $token['usableOn'];
        $this->data = $token['data'];
    }
    public function used(){
        $this->used = 1;
        $query = "UPDATE tokens SET used=1 WHERE token=:token";
        $params['token'] = $this->token;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
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