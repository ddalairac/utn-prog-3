<?php

require_once __DIR__ ."./../../vendor/autoload.php"; 
require_once "./../../interfaces/country-list.php"; 
require_once "./../../interfaces/country.php"; 
require_once "./../../classes/place.php"; 
require_once "./../../classes/country-list.php"; 
require_once "./../../classes/country.php"; 

$countries = new countryList();

// $parameter = $_SERVER['QUERY_STRING'];
// echo $parameter."<br>";

if(isset($_GET['name'])){
    $name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);
    try{
        $country = $countries->getbyName($name);
        $json = json_encode($country);
        echo $json;
    } catch (Exception $e){
        echo "Error en consultando pais: $name <br>", $e->getMessage();
    }
}

?>