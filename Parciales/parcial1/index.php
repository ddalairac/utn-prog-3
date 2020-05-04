<?php
/* puntos a resolver en el PDF*/

require_once __DIR__ . "./vendor/autoload.php";
include_once "./class/response.class.php";
include_once "./class/autenticate.class.php";
include_once "./class/file-data.class.php";
include_once "./class/file-img.class.php";
include_once "./class/bin-data.class.php";
include_once "./class/users.class.php";
include_once "./class/product.class.php";

// error_reporting(0);
// ini_set('display_errors', 0);   
$metodo = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '';

if ($path != '/usuario' && $path != '/login') {
    $jwtData = getallheaders()['token'] ?? '';
    try {
        $payload = Autenticate::jwtDecode($jwtData);
    } catch (\Throwable $th) {
        exit(Response::data2DTO("Error", 401, "No autorizado."));
    }
}

if ($path != '') {
    switch ($metodo) {
        case 'POST':
            switch ($path) {
                case '/usuario': // ------------------------------------------------------------------------------------------------------
                    if (isset($_POST['email']) && isset($_POST['clave']) && isset($_POST['tipo'])) {
                        $auth = Autenticate::signin($_POST['email'], $_POST['clave'], $_POST['tipo']);
                        if (!is_int($auth)) {
                            echo Response::data2DTO("Success", 201, (object) array("token" => $auth));
                        } else if ($auth == 409) {
                            echo Response::data2DTO("Fail", 400, "Ya existe un usuario con el email " . $_POST['email']);
                        } else {
                            echo Response::data2DTO("Error", $auth, "No se pudo crear el usuario por un error interno.");
                        }
                    } else {
                        echo Response::data2DTO("Error", 400, "Datos en solicitud incorrectos.");
                    }
                    break;

                case '/login': // --------------------------------------------------------------------------------------------------------
                    if (isset($_POST['email']) && isset($_POST['clave'])) {
                        $auth = Autenticate::login($_POST['email'], $_POST['clave']);
                        if (!is_int($auth)) {
                            echo Response::data2DTO("Success", 200, (object) array("token" => $auth));
                        } else  if ($auth == 401) {
                            echo Response::data2DTO("Fail", 401, "email o clave incorrecta.");
                        } else {
                            echo Response::data2DTO("Error", $auth, "No se pudo crear el usuario por un error interno");
                        }
                    } else {
                        echo Response::data2DTO("Error", 400, "Solicitud incorrecta.");
                    }
                    break;
                case '/pizzas': // --------------------------------------------------------------------------------------------------------

                    if ($payload->typ == "encargado") {
                        if (isset($_POST['tipo']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_POST['sabor']) && isset($_FILES['foto'])) {
                            if ($_POST['tipo'] == 'molde' || $_POST['tipo'] == 'piedra') {
                                if ($_POST['sabor'] == 'jamón' || $_POST['sabor'] == 'napo' || $_POST['sabor'] == 'muzza') {
                                    $res = Products::setProduct($_POST['tipo'], $_POST['precio'], $_POST['stock'], $_POST['sabor'], new FileImg($_FILES['foto']));
                                    if (!is_int($res)) {
                                        echo Response::data2DTO("Success", 201, $res);
                                    } else {
                                        switch ($res) {
                                            case 400:
                                                echo Response::data2DTO("Error", $res, "El producto ya esta cargado.");
                                                break;
                                            default:
                                                echo Response::data2DTO("Error", $res, "No se pudo cargar el producto por un error interno.");
                                                break;
                                        }
                                    }
                                } else {
                                    echo Response::data2DTO("Fail", 400, "El tipo sabor ser jamón, napo o muzza, " . $_POST['sabor'] . " no es valido");
                                }
                            } else {
                                echo Response::data2DTO("Fail", 400, "El tipo debe ser molde o piedra, " . $_POST['tipo'] . " no es valido");
                            }
                        } else {
                            echo Response::data2DTO("Error", 400, "Datos en solicitud incorrectos.");
                        }
                    } else {
                        echo Response::data2DTO("Error", 403, "No tiene permisos para realizar esta operacion.");
                    }
                    break;
                case '/ventas': // -------------------------------------------------------------------------------------------------------
                    if ($payload->typ == "cliente") {
                        if (isset($_POST['tipo']) && isset($_POST['sabor'])) {

                            $res = Products::setSale($_POST['tipo'], $_POST['sabor'], $payload->sub);
                            if (!is_int($res)) {
                                echo Response::data2DTO("Success", 201, $res);
                            } else {
                                switch ($res) {
                                    case 404:
                                        $message = "No se encontro la combinacion de tipo o sabor.";
                                        break;
                                    case 400:
                                        $message = "No hay stock suficiente para la venta.";
                                        break;
                                    default:
                                        $message = "No se pudo realizar la venta.";
                                        break;
                                }
                                echo Response::data2DTO("Error", $res, $message);
                            }
                        } else {
                            echo Response::data2DTO("Error", 400, "Datos en solicitud incorrectos.");
                        }
                    } else {
                        echo Response::data2DTO("Error", 403, "Los administradores no pueden realizar ventas.");
                    }
                    break;
                default:
                    echo Response::data2DTO("Error", 400, "Solicitud incorrecta.");
                    break;
            }
            break;

        case 'GET': // ------------------------------------------------------------------------------------------------------------------
            switch ($path) {
                case '/pizzas': // -----------------------------------------------------------------------------------------------------
                    $res = Products::getProducts($payload);
                    if (!is_int($res)) {
                        if (Count($res) > 0) {
                            echo Response::data2DTO("Success", 200, $res);
                        } else {
                            echo Response::data2DTO("Success", 204, $res);
                        }
                    } else {
                        echo Response::data2DTO("Error", $res, "Ocurrio un error interno");
                    }
                    break;
                case '/ventas': // -------------------------------------------------------------------------------------------------------
                    $res = Products::getSales($payload);
                    if (!is_int($res)) {
                        if (Count($res) > 0) {
                            echo Response::data2DTO("Success", 200, $res);
                        } else {
                            echo Response::data2DTO("Success", 204, $res);
                        }
                    } else {
                        echo Response::data2DTO("Error", $res, "Ocurrio un error interno");
                    }
                    break;
                default:
                    echo Response::data2DTO("Error", 400, "Solicitud incorrecta.");
                    break;
            }
            break;

        default:
            echo Response::data2DTO("Error", 405, "Método no permitido.");
            break;
    }
} else {
    echo Response::data2DTO("Error", 404, "Seleccione un medoto.");
}
