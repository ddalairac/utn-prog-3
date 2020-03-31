<?php

require_once __DIR__ ."./../../vendor/autoload.php"; 
require_once "./../../interfaces/country-list.php"; 
require_once "./../../classes/country-list.php"; 

$countries = new countryList();
try{
    $json = json_encode($countries->getAll());
    echo $json;
} catch (Exception $e){
    echo "Error consultando paises: todos <br>", $e->getMessage();
}

?>