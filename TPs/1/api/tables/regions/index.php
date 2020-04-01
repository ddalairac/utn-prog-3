<?php
require_once __DIR__ ."./../../../vendor/autoload.php"; 
require_once "./../../../interfaces/country.php"; 
require_once "./../../../interfaces/country-list.php"; 
require_once "./../../../classes/place.php"; 
require_once "./../../../classes/country.php"; 
require_once "./../../../classes/country-list.php"; 
require_once "./../../../classes/dto.php"; 
require_once "./../../../classes/tables.php"; 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    $tables = new Tables();
    $data = $tables->getRegions(); 
    echo DTO::serialize($data);
} catch (\Exception $e) {
    echo "Error consultando tabla de regiones \n"; 
    echo $e->getMessage();
}






?>