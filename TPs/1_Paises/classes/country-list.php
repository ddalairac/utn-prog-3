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

    
    public function getbyRegion($region){
        $list = [];
        foreach ($this->restCountries->all() as $c) {
            if($c->region == $region){
                $list[] = $c;
            } 
        }
        return $list;
    }
    public function getbySubRegion($subregion){
        $list = [];
        foreach ($this->restCountries->all() as $c) {
            if($c->subregion == $subregion){
                $list[] = $c;
            }
        }
        return $list;
    }
    public function getbyCapital($capital){
        $list = [];
        foreach ($this->restCountries->all() as $c) {
            if($c->capital == $capital){
                $list[] = $c;
            }
        }
        return $list;
    }
    
    public function getbyLanguages($language){
        $list = [];
        foreach ($this->restCountries->all() as $c) {
            foreach ($c->languages as $cLan) {
                if($cLan->name == $language){
                    $list[] = $c;
                }
            }
        }
        return $list;
    }
}


?>