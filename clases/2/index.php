<?php
/**
 * Metodos HTTP
 * --------------
 * GET: obtener
 * POST: crear
 * PUT: modificar
 * DELETE: borrar
 * */  

 function mostrar($data){
    echo json_encode( $data, JSON_PRETTY_PRINT);
 }
//  mostrar($_GET);
//  mostrar($_POST);
//  mostrar($_REQUEST); // sirve para cualquier peticion, pero perdemos referencia de que tipo es
//  mostrar($_SERVER); // Informaciond e la peticion


 include_once "./class/file.class.php";
 $metodo = $_SERVER['REQUEST_METHOD'];
 $path = null;
 if (isset($_SERVER['PATH_INFO'])){
    $path = $_SERVER['PATH_INFO'];
 }
 $file = new File();
 if($metodo == 'GET'){
    // echo "metodo get".PHP_EOL;
    switch ($path) {
        case '/all':
            echo  $file->readAll();
            break;
        case '/byid':
            if(isset($_GET['id'])){
                echo  $file->readByID($_GET['id']);
            }
            break;
        case '/backup':
            echo  $file->backup();
            break;
        
        default:
            # code...
            break;
    }
} else if($metodo == 'POST'){
    // echo "metodo post".PHP_EOL;
 } else {
     echo "error 405, motodo no permitido.";
 }





?>