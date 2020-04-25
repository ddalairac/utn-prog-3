<?php
$countries = new countryList();
try{
    $countries = $countries->getbySubRegion($params["subregion"]);
    echo DTO::serialize($countries);
} catch (Exception $e){
    echo "Error consultando paises por sub region: ".$params["subregion"]."\n";
    echo $e->getMessage();
}
?>