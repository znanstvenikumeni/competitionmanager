<?php


class DataRequest
{
    private $conn;
    private $Applications;
    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }
    function fetchApplications(){
        $Application = new Application($pdo);
        $Applications = $Application->byUser($Session->aai);
    }
    function fetch
}