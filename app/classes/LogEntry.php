<?php

class LogEntry{
    private $conn;
    
    public $user;
    public $session;
    public $component;
    public $action;
    public $result;
    public $time;
    public $ip;
    public $useragent;
    public $data;
    public function __construct(\PDO $pdo, $component, $action, $result = null, $data = null, $user = null, $session = null) {
        $this->conn = $pdo;
        $this->time = time();
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->useragent = $_SERVER['HTTP_USER_AGENT'];
        $this->component = $component;
        $this->action = $action;
        $this->result = $result;
        $this->data = $data;
        $this->user = $user;
        $this->session = $session;
        if(!is_int($this->session) && !is_null($this->session)){
            $Session = new Session($this->conn);
            $Session->token = $this->session;
            $Session->load();
            $this->session = $Session->id;
        }
        $this->save();
    }

    private function save(){
        $this->logToDatabase();
        $this->logToFile();
    }

    private function logToFile(){
        file_put_contents("../storage/logs/security.log", $this->formatLogEntry(), FILE_APPEND);
    }

    private function logToDatabase(){
        $query = "INSERT INTO logs VALUES (null, :user, :session, :component, :action, :result, :time, :ip, :useragent, :data)";
        $params['user'] = $this->user;
        $params['session'] = $this->session;
        $params['component'] = $this->component;
        $params['action'] = $this->action;
        $params['result'] = $this->result;
        $params['time'] = $this->time;
        $params['ip'] = $this->ip;
        $params['useragent'] = $this->useragent;
        $params['data'] = $this->data;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
    }

    private function formatLogEntry(){
        $string = "Security error in: [$this->component] on action: [$this->action] ([$this->result]): occured for user [$this->user] and session [$this->session] at time [$this->time] with IP [$this->ip] and on user agent [$this->useragent]. Additional data: [$this->data] \n";
        return $string;
    }
}