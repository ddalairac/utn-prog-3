<?php
$countries = new countryList();
try{
    $all = $countries->getAll();
    echo DTO::serialize($all);
} catch (Exception $e){
    echo "Error consultando paises: todos \n"; 
    echo $e->getMessage();
}
?>