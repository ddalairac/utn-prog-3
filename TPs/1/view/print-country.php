<!DOCTYPE html>
<html>
<head>
    <title>TP1</title>
    <meta charset="UTF-8">
    <meta name="description" content="Info de paises">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="./styles.css" media="screen">
</head>
<body>
<?php 
require_once "./view-required-imports.php"; 

$cl = new CountryList();
// print_r($cl->getAll()); 

$clItem = $cl->getbyName("Argentina");
$c = new Country($clItem);?>
<div class="container">
    <a href="./../" class="volver">< vovler</a>
    <h1>Metodos</h1>
    <div class="row">
        <div class="col col-2">
            <h2>Instancia</h2><hr>
            <code>$c->getInfo();</code>
            <p><?php echo $c->getInfo()?></p>
        </div>
        <div class="col col-2">
            <h2>Clase</h2><hr>
            <code>Country::getCountryInfo($clItem);</code>
            <p><?php echo Country::getCountryInfo($clItem); ?></p>
        </div>
    </div>
    
    <h1>CountryList Item Data</h1>
    <div class="row">
        <div class="col col-2">
            <h2>Print Object</h2><hr>
            <pre><?php print_r($c->getObject()); ?></pre>
        </div>
        <div class="col col-2">
            <h2>Json</h2><hr>
            <pre><?php echo DTO::serialize($c->getObject()); ?></pre>
        </div>
    </div>
</div>
</body>
</html>