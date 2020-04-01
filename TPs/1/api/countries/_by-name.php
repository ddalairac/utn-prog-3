<?php
$countries = new countryList();
try{
    $country = $countries->getbyName($params["name"]);
    echo DTO::serialize($country);
} catch (Exception $e){
    echo "Error en consultando pais: ".$params["name"]."\n";
    // echo $e->getMessage();
}
?>