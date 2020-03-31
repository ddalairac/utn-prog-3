<?php
use NNV\RestCountries;

class CountryList implements ICountryList{
    
    private $restCountries;
    public function __construct(){
        $this->restCountries = new RestCountries;
    }

    public function getAll(){
        $countries = $this->restCountries->all();
        return $countries;
    }

    public function getbyName($name){
        return $this->restCountries->byName($name);
    }
}


?>