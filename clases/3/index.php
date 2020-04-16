<?php
 include_once "./class/file-data.class.php";
 include_once "./class/file-img.class.php";
 include_once "./class/response.class.php";
 include_once "./class/persona.class.php";


$metodo = $_SERVER['REQUEST_METHOD'];
$path = null;
if (isset($_SERVER['PATH_INFO'])){
    $path = $_SERVER['PATH_INFO'];
}
$persona = new Persona();
// $img = new FileImg($_FILES['image']);


switch ($path) {
    case '/persona':
        switch ($metodo){
            case 'GET':
                if(Count($_GET) == 0){
                    echo Response::data2DTO("Success",$persona->getAll() ); 
                } else if(isset($_GET['id'])){
                    echo Response::data2DTO("Success",$persona->getByID($_GET['id']) );
                } else {
                    echo Response::data2DTO("Error","Metodo no encontrado.");
                }
                break;

            case 'POST':
                if(Count($_POST) == 0){
                    echo Response::data2DTO("Error","No se recibieron parametros");
                } else if(isset($_POST['id']) && isset($_POST['name']) ){
                    $data = $persona->edit($_POST['id'],$_POST['name']);
                    if(!$data){
                        echo Response::data2DTO("Fail","No se encontro el ID");
                    } else {
                        echo Response::data2DTO("Success",$data);
                    }

                } else if( isset($_POST['name']) ){
                    echo Response::data2DTO("Success",$persona->add($_POST['name']));
                
                } else if( isset($_POST['id']) ){
                    $data = $persona->removeByID($_POST['id']);
                    if(!$data){
                        echo Response::data2DTO("Fail","No se encontro el ID");
                    } else {
                        echo Response::data2DTO("Success",$data);
                    }
                    
                } else {
                    echo Response::data2DTO("Error","Parametros incorrectos.");
                }
                break;

            default:
                echo Response::data2DTO("Error","405, Metodo no permitido.");
                break;
        }
        break;

    default:
        echo Response::data2DTO("Error","404, operacion no encontrado.");
        break;
}






?>