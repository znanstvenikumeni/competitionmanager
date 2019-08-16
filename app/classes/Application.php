<?php
class Application{
    private $conn;

    public $id;
    public $title;
    public $description;
    public $vmssID;
    public $mentors;
    public $teamMembers;
    public $status;
    public $year;
    public $data;

    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }

    public function byUser($user){
        $query = "SELECT * FROM applications WHERE teamMembers LIKE concat('%', :user, '%') ORDER BY year DESC LIMIT 1";
        $params['user'] = $user;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $application = $statement->fetch(PDO::FETCH_ASSOC);
        foreach($application as $key=>$value){
            $this->$key = $value;
        }
    }
    
}