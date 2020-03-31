<?php

abstract class Place implements ICountry{
    private $name;
    private $alpha2Code;
    private $region;
    
    private $country;
    
    public function __construct($country){
        $this->name = $country[0]->name;
        $this->code = $country[0]->alpha2Code;
        $this->region = $country[0]->region;
        
        $this->country = $country[0];
    }
    public static function getCountryInfo($country){
        $message = "";
        $message .= "code: $country->alpha2Code <br>";
        $message .= "name: $country->name <br>";
        $message .= "region: $country->region <br>";
        return $message;
    }
    public function getInfo(){
        $message = "";
        $message .= "code: $this->code <br>";
        $message .= "name: $this->name <br>";
        $message .= "region: $this->region <br>";
        return $message;
    }
    public function getObject(){
        return $this->country;
    }
}

?>