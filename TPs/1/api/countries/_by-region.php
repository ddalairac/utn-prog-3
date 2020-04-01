<?php
$countries = new countryList();
try{
    $countries = $countries->getbyRegion($params["region"]);
    echo DTO::serialize($countries);
} catch (Exception $e){
    echo "Error consultando paises por continete: ".$params["region"]."\n";
    echo $e->getMessage();
}
?>