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
        $query = "SELECT * FROM applications WHERE teamMembers LIKE concat('%', :user, '%') ORDER BY year DESC";
        $params['user'] = $user;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $application = $statement->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($application);
        $Applications = [];
        foreach($application as $row){
            $App = new Application($this->conn);
            foreach($row as $key=>$value){
                $App->$key = $value;
            }
            array_push($Applications, $App);
        }
        
        return $Applications;
    }
    
}