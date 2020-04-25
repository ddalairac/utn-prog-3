<?php 
/* Crear una API rest con las siguientes rutas:
1- POST signin: recibe email, clave, nombre, apellido, telefono y tipo (user, admin) y lo guarda en un archivo.
2- POST login: recibe email y clave y chequea que existan, si es así retorna un JWT de lo contrario informa el error (si el email o la clave están equivocados) .
A PARTIR DE AQUI TODAS LAS RUTAS SON AUTENTICADAS.
3- GET detalle: Muestra todos los datos del usuario actual.
4- GET lista: Si el usuario es admin muestra todos los usuarios, si es user solo los del tipo user. */

require_once __DIR__ ."./vendor/autoload.php"; 
include_once "./class/response.class.php";
include_once "./class/autenticate.class.php";
include_once "./class/file-data.class.php";
include_once "./class/users.class.php";

error_reporting(0);
ini_set('display_errors', 0);   
$metodo = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '';


switch ($metodo) {
    case 'POST':
        switch ($path){
            case '/signin': // ------------------------------------------------------------------------------------------------------
                if(isset($_POST['email']) && isset($_POST['clave']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['tipo'])){
                    $auth = Autenticate::signin($_POST['email'],$_POST['clave'],$_POST['nombre'],$_POST['apellido'],$_POST['telefono'],$_POST['tipo'],$_POST['email'],$_POST['clave']);
                    if(!is_int($auth)){
                        echo Response::data2DTO("Success",201,(object)array("token" => $auth));
                    } else if ($auth == 409){
                        echo Response::data2DTO("Fail",409, "Ya existe un usuario con el mail ".$_POST['email']);
                    } else {
                        echo Response::data2DTO("Error",$auth, "No se pudo crear el usuario por un error interno.");
                    }
                } else {
                    echo Response::data2DTO("Error",400, "Datos en solicitud incorrectos.");
                }
                break;

            case '/login': // --------------------------------------------------------------------------------------------------------
                if(isset($_POST['email']) && isset($_POST['clave'])){
                    $auth = Autenticate::login($_POST['email'], $_POST['clave']);
                    if(!is_int($auth)){
                        echo Response::data2DTO("Success",200,(object)array("token" => $auth));
                    } else  if ($auth == 401){
                        echo Response::data2DTO("Fail",401, "email o clave incorrecta.");
                    } else {
                        echo Response::data2DTO("Error",$auth, "No se pudo crear el usuario por un error interno");
                    }
                } else {
                    echo Response::data2DTO("Error",400, "Solicitud incorrecta.");
                }
                break;
            default:
                echo Response::data2DTO("Error",400, "Solicitud incorrecta.");
                break;
        }
        break;

    case 'GET': // ------------------------------------------------------------------------------------------------------------------
        $jwtData = getallheaders()['token'] ?? '';
        try {
            $decoded = Autenticate::jwtDecode($jwtData);
        } catch (\Throwable $th) {
            exit(Response::data2DTO("Error",401, "No autorizado."));
        }
        
        switch ($path){
            case '/detalle': // -----------------------------------------------------------------------------------------------------
                $res = Users::getUser($decoded->sub);
                if(!is_int($res)){
                    if($res != null){
                        echo Response::data2DTO("Success",200, $res);
                    } else {
                        echo Response::data2DTO("Fail",204, $res);
                    } 
                } else {
                    echo Response::data2DTO("Error",$res, "Ocurrio un error interno");
                }
                break;
            case '/lista': // -------------------------------------------------------------------------------------------------------
                if($decoded->typ == "admin"){
                    $res = Users::getAll();
                } else {
                    $res = Users::getUsers();
                }
                if(!is_int($res)){
                    if(Count($res) > 0){
                        echo Response::data2DTO("Success",200, $res);
                    } else {
                        echo Response::data2DTO("Fail",204, $res);
                    }
                } else {
                    echo Response::data2DTO("Error",$res, "Ocurrio un error interno");
                }
                break;
            default:
                echo Response::data2DTO("Error",400, "Solicitud incorrecta.");
                break;
        }
        break;

    default:
        echo Response::data2DTO("Error",405, "Método no permitido.");
        break;
}
?>