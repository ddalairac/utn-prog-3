<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./styles.css" media="screen">
</head>
<body>
<?php 
require_once "./required-imports.php"; 
$cl = new CountryList();
$allCountries = $cl->getAll();

// ----------------------- datos para combos ---------------------------- //
$regions = array(); 
$subRegions = array();  
$languages = array();   
$capitals = array();    

foreach ($allCountries as $c) {
    // Continentes
    $has = false;
    foreach ($regions as $r) { if($r == $c->region){  $has = true; } }
    if($has == false && $c->region){ $regions[] = $c->region; }

    // Sub Regiones
    $has = false;
    foreach ($subRegions as $sr) { if($sr == $c->subregion){  $has = true; } }
    if($has == false && $c->subregion){ $subRegions[] = $c->subregion; }

    // Idiomas
    $has = false;
    foreach ($c->languages as $cLan) {
        foreach ($languages as $l) { 
            if($l == $cLan->name){  $has = true; } 
        }
        if($has == false && $cLan->name){ $languages[] = $cLan->name;} 
    }

    // Capitales
    $has = false;
    foreach ($capitals as $r) { if($r == $c->capital){  $has = true; } }
    if($has == false && $c->capital){ $capitals[] = $c->capital; }
}

// ----------------------- funciones ---------------------------- //
function submit(){
    document.getElementById("my-form").submit();
}
function printRegiones($region){
    $cl = new CountryList();
    $allCountries = $cl->getAll();
    $message = "<ul>";
    foreach ($allCountries as $c) {
        if($c->region == $region){
            $message .= "<li>".$c->name."</li>";
        }
    }
    $message .= "</ul>";
    return $message;
}

function printSubRegiones($subregion){
    $cl = new CountryList();
    $allCountries = $cl->getAll();
    $message = "<ul>";
    foreach ($allCountries as $c) {
        if($c->subregion == $subregion){
            $message .= "<li>".$c->name."</li>";
        }
    }
    $message .= "</ul>";
    return $message;
}

function printLanguages($language){
    $cl = new CountryList();
    $allCountries = $cl->getAll();
    $message = "<ul>";
    foreach ($allCountries as $c) {
        foreach ($c->languages as $cLan) {
            if($cLan->name == $language){
                $message .= "<li>".$c->name."</li>";
            }
        }
    }
    $message .= "</ul>";
    return $message;
}

function printCapitals($capital){
    $cl = new CountryList();
    $allCountries = $cl->getAll();
    $message = "<ul>";
    foreach ($allCountries as $c) {
        if($c->capital == $capital){
            $message .= "<li>".$c->name."</li>";
        }
    }
    $message .= "</ul>";
    return $message;
}
?>


<div class="container">
    <a href="./../" class="volver">< vovler</a>
    <div class="row">
        <div class="col col-2">


            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" name="myform">
                <h2>Seleccionar</h2>
                <label>Por continente: </label>
                <select id="idregion" name="region" onchange="myform.submit();">
                    <option value='' >none</option><?php 
                    foreach ( $regions as $value) {
                        echo "<option value='".$value."' >".$value."</option>";
                    }?>
                </select><br>

                
                <label>Por sub región: </label>
                <select id="idsubregion" name="subregion" onchange="myform.submit();">
                    <option value='' >none</option><?php 
                    foreach ($subRegions as $value) {
                        echo "<option value='".$value."' >".$value."</option>";
                    }?>
                </select><br>


                <label>Por idioma: </label>
                <select id="idlanguage" name="language" onchange="myform.submit();">
                    <option value='' >none</option><?php 
                    foreach ($languages as $value) {
                        echo "<option value='".$value."' >".$value."</option>";
                    }?>
                </select><br>


                <label>Por capital: </label>
                <select id="idcapital" name="capital" onchange="myform.submit();">
                    <option value='' >none</option><?php 
                    foreach ($capitals as $value) {
                        echo "<option value='".$value."' >".$value."</option>";
                    }?>
                </select><br>

            </form>
        </div>  
        <div class="col col-2">


            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $selectRegion = $_POST['region'];
                $selectSubregion = $_POST['subregion'];
                $selectLanguage = $_POST['language'];
                $selectCapital = $_POST['capital'];
                if (!empty($selectRegion)) {
                    echo "<h2>Busqueda por continente: </h2> <h3>$selectRegion </h3>";
                    echo printRegiones($selectRegion);
                } else if (!empty($selectSubregion)) {
                    echo "<h2>Busqueda por sub region: </h2> <h3>$selectSubregion </h3>";
                    echo printSubRegiones($selectSubregion);
                } else if (!empty($selectLanguage)) {
                    echo "<h2>Busqueda por idioma: </h2> <h3>$selectLanguage </h3>";
                    echo printLanguages($selectLanguage);
                } else if (!empty($selectCapital)) {
                    echo "<h2>Busqueda por capital: </h2> <h3>$selectCapital </h3>";
                    echo printCapitals($selectCapital);
                    // print_r($pais);
                } else {
                    echo "No hay resultados";
                }
            }  ?>



        </div>  
    </div><!-- row -->
            


</div><!-- container -->


<pre> <?php //print_r($allCountries); ?></pre>

</body>
</html>