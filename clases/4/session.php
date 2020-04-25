<?php
session_start();

print_r($_SESSION); 
echo "\n";
if(isset($_SESSION['nombre'])){
    echo "Hola session".$_SESSION['nombre']."\n";
    echo "Hola cookie".$_COOKIE['usuario']."\n";
} else {
    $_SESSION['nombre'] = $_GET['nombre'] ?? "NN";
    setcookie('usuario',$_SESSION['nombre']);
}

// crear api de logueo, con 2 perfiles que genere un token