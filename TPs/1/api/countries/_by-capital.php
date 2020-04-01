<?php
$countries = new countryList();
try{
    $countries = $countries->getbyCapital($params["capital"]);
    echo DTO::serialize($countries);
} catch (Exception $e){
    echo "Error consultando paises por capital: ".$params["capital"]."\n";
    echo $e->getMessage();
}
?>