<?php
// require_once __DIR__ ."./vendor/autoload.php"; 
// require_once "./interfaces/country-list.php"; 
// require_once "./interfaces/country.php"; 
// require_once "./classes/place.php"; 
// require_once "./classes/country.php"; 
// require_once "./classes/country-list.php"; 



// $cl = new CountryList();
// // echo $cl->getList(); 
// // printf($cl->getList()); 
// // print_r($cl->getAll()); 
// // print_r($cl->getbyName("Argentina")); 
// // echo '<pre>'; print_r($cl->getbyName("Argentina")); echo '</pre>';


// $c = new Country($cl->getbyName("Argentina"));

// print_r($cl->getbyName("Argentina"));
// // echo '<h2>Metodo instancia</h2>';
// // echo '<p>'.$c->getInfo().'</p>';

// // echo '<h2>Metodo clase</h2>';
// // echo '<p>'.Country::getCountryInfo($cl->getbyName("Argentina")).'</p>'; 
// // $serch = $cl->getbyName("Argentina");
// // // echo "Pais: ".$serch[0]->name." <br> <br>";
// // // echo Country::getCountryInfo($country[0]); 
// // echo '<pre>'; print_r($serch); echo '</pre>';

// // echo $c->getData(); 

// // use NNV\RestCountries;
// // $restCountries = new RestCountries;

?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./view/styles.css" media="screen">
</head>
<body>
<div class="container">
    <h1>Pruebas</h1>
    <div class="row">
        <div class="col col-2">
            <h2>Templates</h2>
            <a href="./view/search.php">Buscar pais por nombre</a>
            <a href="./view/search-list.php">Buscar grupo de paises</a>
            <a href="./view/print-country.php">Metodos estaticos y de intancia</a>
        </div>
        <div class="col col-2">
            <h2>Api</h2>
            <a href="./api/country/?name=arg">api/country</a>
            <a href="./api/all">api/all</a>
        </div>
    </div>
</div>
</body>
</html>