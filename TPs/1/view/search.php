<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./styles.css" media="screen">
</head>
<body>
<?php 
require_once "./required-imports.php"; 
$cl = new CountryList();
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <div class="container">
        <a href="./../" class="volver">< vovler</a>
        <div class="row">
            <div class="col col-2">
                <h2>Seleccionar</h2>
                <label>Elegir un pais: </label>
                <select id="list" name="listCountry"><?php 
                echo "<option value='' >none</option>";
                foreach ($cl->getAll() as $value) {
                    echo "<option value='".$value->name."' >".$value->name."</option>";
                }?>
                </select><br>
            </div>  
            <div class="col col-2">
                <h2>Buscar</h2>
                <label>Buscar por nombre: </label>
                <input type="text" name="searchCountry">
            </div>  
        </div><!-- row -->
        <div class="action"> 
            <button type="submit">Aceptar</button>
        </div>
        <!-- <input type="text" > -->
        <!-- <pre><?php print_r($cl->getAll()) ?></pre> -->

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {?>
        <div class="row">
            <div class="col">
                <h2>Resultado</h2><?php 
                $search = $_POST['searchCountry'];
                $listItem = $_POST['listCountry'];
                if (!empty($search)) {
                    echo "Busqueda: $search <br>";
                    $pais = $cl->getbyName($search);
                    $c = new Country($pais);
                    echo $c->getInfo();
                    // print_r($pais);
                } else if (!empty($listItem)) {
                    echo "Seleccion: $listItem <br>";
                    $pais = $cl->getbyName($listItem);
                    $c = new Country($pais);
                    echo $c->getInfo();
                    // print_r($pais);
                } else {
                    echo "No se selecciono un pais";
                }
                ?>
            </div>  
        </div><!-- row -->

        <?php  }  ?>

    </div><!-- container -->
</form>

</body>
</html>