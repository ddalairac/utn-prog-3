<?php
$countries = new countryList();
try{
    $countries = $countries->getbyLanguages($params["language"]);
    echo DTO::serialize($countries);
} catch (Exception $e){
    echo "Error consultando paises por idioma: ".$params["capital"]."\n";
    echo $e->getMessage();
}
?>