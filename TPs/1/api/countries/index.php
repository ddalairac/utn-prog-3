<?php
require_once "./api-required-imports.php"; 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// echo $_SERVER['REQUEST_URI']."\n";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
// echo $uri."\n";

parse_str($uri, $params);
// print_r($params);

if (empty($params)) {
    // Coleccion completa de paises
    include_once "./_all.php";
    
} else {
    // filtro
    if(isset($params["name"])){
        include_once "./_by-name.php";
    } else if(isset($params["region"])){
        include_once "./_by-region.php";
    } else if(isset($params["subregion"])){
        include_once "./_by-subregion.php";
    } else if(isset($params["language"])){
        include_once "./_by-language.php";
    } else if(isset($params["capital"])){
        include_once "./_by-capital.php";
    } else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
}







?>