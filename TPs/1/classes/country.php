<?php

class Country extends Place implements ICountry{
   
    private $capital;
    
    
    public function __construct($country){
        parent ::__construct($country);
        $this->capital = $country[0]->capital;
        $this->region = $country[0]->region;
    }
    public static function getCountryInfo($country){
        $message = "";
        $message .= parent::getCountryInfo($country[0]);
        $message .= "capital: ".$country[0]->capital." <br>";
        return $message;
    }
    public function getInfo(){
        $message = "";
        $message .= parent::getInfo();
        $message .= "capital: ".$this->capital." <br>";
        return $message;
    }
}

?>