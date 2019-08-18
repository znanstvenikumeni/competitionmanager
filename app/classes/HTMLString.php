<?php

class HTMLString{
    public $string;

    public function __construct($string, $echo=false){
        $this->string = htmlentities($string, ENT_HTML5, "UTF-8");
        if($echo){
            echo $this->string;
        }
    }
    
    public function echo(){
        echo $this->string;
    }

    public function print(){
        return $this->string;
    }
}