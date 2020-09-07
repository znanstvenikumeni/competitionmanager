<?php


class PhoneNumberVerification
{
    private $conn;
    public $User;
    public $PhoneNumber;
    public $VerificationCode;
    public $TimeSent;
    public $Verified;
    private $Twilio;

    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }
    public function passTwilio($Twilio){
        $this->Twilio = $Twilio;
    }
    public function isVerified($User, $PhoneNumber){
        $this->User = $User;
        $this->PhoneNumber = $PhoneNumber;
        $query = "SELECT COUNT(*) AS count FROM phoneNumberVerifications WHERE userID = :user AND phoneNumber = :phone AND verified = 1";
        $params['user'] = $this->User;
        $params['phone'] = $this->PhoneNumber;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        if($res['count'] > 0) return true;
        return false;
    }

    public function canSend($User, $PhoneNumber){
        $query = "SELECT COUNT(*) AS count FROM phoneNumberVerifications WHERE userID = :user AND phoneNumber = :phone AND timeSent >= :time";
        $minTimeSent = strtotime('-5 minutes');
        $params['user'] = $this->User;
        $params['phone'] = $PhoneNumber;
        $params['time'] = $minTimeSent;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        if($res['count'] > 0) return false;
        return true;
    }
    public function formatNumber($PhoneNumber){
        $PhoneNumber = preg_replace('/[^0-9]/','',$PhoneNumber);
        $PhoneNumber = str_replace('00385', '', $PhoneNumber);
        $PhoneNumber = str_replace('385', '', $PhoneNumber);
        if($PhoneNumber[0] == '0') $PhoneNumber = substr($PhoneNumber, 1);
        $this->PhoneNumber = '+385'.$PhoneNumber;
        return $this->PhoneNumber;
    }
    public function setVerificationRequest($PhoneNumber){
        $code = random_int(100000, 999999);
        $query = "INSERT INTO phoneNumberVerifications VALUES (:user, :phone, :code, :time, 0)";
        $params['user'] = $this->User;
        $params['phone'] = $PhoneNumber;
        $params['code'] = $code;
        $params['time'] = time();
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $this->formatNumber($PhoneNumber);
        $message = $this->Twilio->messages->create($this->PhoneNumber,
                array(
                    "from" => "ZUM",
                    "body" => "Tvoj kod potvrde za ZUM je ".$code
                )
            );
    }
    public function validateVerificationRequest($PhoneNumber, $Code){
        $minTimeSent = strtotime('-5 minutes');
        $query = "SELECT * FROM phoneNumberVerifications WHERE userID = :user AND phoneNumber = :phone AND timeSent >= :time AND verificationCode = :code";
        $params['user'] = $this->User;
        $params['phone'] = $PhoneNumber;
        $params['time'] = $minTimeSent;
        $params['code'] = $Code;
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        $res = $statement->fetch(PDO::FETCH_ASSOC);
        if($res){
            $query = "UPDATE phoneNumberVerifications SET verified = 1 WHERE userID = :user AND phoneNumber = :phone AND timeSent >= :time AND verificationCode = :code";
            $statement = $this->conn->prepare($query);
            $statement->execute($params);
            return true;
        }
        return false;
    }
}