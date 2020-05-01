<?php 
/* puntos a resolver en el PDF*/

require_once __DIR__ ."./vendor/autoload.php"; 
include_once "./class/response.class.php";
include_once "./class/autenticate.class.php";
include_once "./class/file-data.class.php";
include_once "./class/file-img.class.php";
include_once "./class/users.class.php";
include_once "./class/product.class.php";

// error_reporting(0);
// ini_set('display_errors', 0);   
$metodo = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '';

if($path != '/usuario' && $path != '/login'){
$jwtData = getallheaders()['token'] ?? '';
    try {
        $decoded = Autenticate::jwtDecode($jwtData);
    } catch (\Throwable $th) {
        exit(Response::data2DTO("Error",401, "No autorizado."));
    }
}

switch ($metodo) {
    case 'POST':
        switch ($path){
            case '/usuario': // ------------------------------------------------------------------------------------------------------
                if(isset($_POST['nombre']) && isset($_POST['clave']) && isset($_POST['dni']) && isset($_POST['obra_social']) && isset($_POST['tipo'])){
                    $auth = Autenticate::signin($_POST['nombre'],$_POST['clave'],$_POST['dni'],$_POST['obra_social'],$_POST['tipo'],$_POST['nombre'],$_POST['clave']);
                    if(!is_int($auth)){
                        echo Response::data2DTO("Success",201,(object)array("token" => $auth));
                    } else if ($auth == 409){
                        echo Response::data2DTO("Fail",409, "Ya existe un usuario con el nombre ".$_POST['nombre']);
                    } else {
                        echo Response::data2DTO("Error",$auth, "No se pudo crear el usuario por un error interno.");
                    }
                } else {
                    echo Response::data2DTO("Error",400, "Datos en solicitud incorrectos.");
                }
                break;

            case '/login': // --------------------------------------------------------------------------------------------------------
                if(isset($_POST['nombre']) && isset($_POST['clave'])){
                    $auth = Autenticate::login($_POST['nombre'], $_POST['clave']);
                    if(!is_int($auth)){
                        echo Response::data2DTO("Success",200,(object)array("token" => $auth));
                    } else  if ($auth == 401){
                        echo Response::data2DTO("Fail",401, "nombre o clave incorrecta.");
                    } else {
                        echo Response::data2DTO("Error",$auth, "No se pudo crear el usuario por un error interno");
                    }
                } else {
                    echo Response::data2DTO("Error",400, "Solicitud incorrecta.");
                }
                break;
            case '/stock': // --------------------------------------------------------------------------------------------------------
                if($decoded->typ == "admin"){
                    if(isset($_POST['producto']) && isset($_POST['marca']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_FILES['foto'])){
                        if($_POST['producto'] == 'vacuna' || $_POST['producto'] == 'medicamento'){
                            // $isValidImg = FileImg::isValidImg($_FILES['foto']);
                            // if ($isValidImg->valid) {
                                $res = Products::setProduct($_POST['producto'], $_POST['marca'], $_POST['precio'], $_POST['stock'], new FileImg($_FILES['foto']));
                                if(!is_int($res)){
                                    echo Response::data2DTO("Success",201,$res);
                                } else {
                                    echo Response::data2DTO("Error",$res, "No se pudo cargar el producto por un error interno.");
                                }
                            // } else {
                            //     echo Response::data2DTO("Fail",409,$isValidImg->message);
                            // } 
                        } else {
                            echo Response::data2DTO("Fail",409, "El producto debe ser vacuna o medicamento, ".$_POST['producto']." no es valido");
                        }
                    } else {
                        echo Response::data2DTO("Error",400, "Datos en solicitud incorrectos.");
                    }
                } else {
                    echo Response::data2DTO("Error",403, "No tiene permisos para realizar esta operacion.");
                }
                break;
            case '/ventas': // -------------------------------------------------------------------------------------------------------
                if($decoded->typ == "user"){
                    if(isset($_POST['id_producto']) && isset($_POST['cantidad'])){
                        
                            $res = Products::setSale($_POST['id_producto'], $_POST['cantidad']);
                            if(!is_int($res)){
                                echo Response::data2DTO("Success",201,$res);
                            } else {
                                switch($res){
                                    case 404:
                                        $message = "No se encontro el id del producto.";
                                        break;
                                    case 409:
                                        $message = "No hay stock suficiente para la venta.";
                                        break;
                                    default:
                                        $message = "No se pudo realizar la venta.";
                                        break;
                                }
                                echo Response::data2DTO("Error",$res, $message);
                            }
                    } else {
                        echo Response::data2DTO("Error",400, "Datos en solicitud incorrectos.");
                    }
                } else {
                    echo Response::data2DTO("Error",403, "Los administradores no pueden realizar ventas.");
                }
                break;
            default:
                echo Response::data2DTO("Error",400, "Solicitud incorrecta.");
                break;
        }
        break;

    case 'GET': // ------------------------------------------------------------------------------------------------------------------
        switch ($path){
            case '/stock': // -----------------------------------------------------------------------------------------------------
                $res = Products::getProducts();
                if(!is_int($res)){
                    if(Count($res) > 0){
                        echo Response::data2DTO("Success",200, $res);
                    } else {
                        echo Response::data2DTO("Success",204, $res);
                    } 
                } else {
                    echo Response::data2DTO("Error",$res, "Ocurrio un error interno");
                }
                break;
            case '/ventas': // -------------------------------------------------------------------------------------------------------
                $res = Products::getSales();
                if(!is_int($res)){
                    if(Count($res) > 0){
                        echo Response::data2DTO("Success",200, $res);
                    } else {
                        echo Response::data2DTO("Success",204, $res);
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