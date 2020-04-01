<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./styles.css" media="screen">
</head>
<body>
<?php 
require_once "./required-imports.php"; 

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
            <pre><?php echo json_encode($c->getObject(), JSON_PRETTY_PRINT); ?></pre>
        </div>
    </div>
</div>
</body>
</html>