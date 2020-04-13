<h1>LAboratorio 3</h1>
<?php
require_once __DIR__ ."./vendor/autoload.php"; // usar dependencias

include './func/funciones.php'; // No es obligatorio, da warning
include_once './func/funciones.php'; // si ya lo incluyo no lo vuelve a agregar
// require './func/funciones.php'; // Es obligatorio, da error
require_once './func/funciones.php'; // idem

SALUDAR("diego"); // no son case sensitive
saludar("diego","Dalairac"); 

$persona = new Persona("Juan");
echo $persona->saludarP();


?>
<!-- 
    crear un proyecto composer para utilizar la api de paises (ya que estamos pruebo el log)
    Clase pais que muestre los datos de argentina 
 -->