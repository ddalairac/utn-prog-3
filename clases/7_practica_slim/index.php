 <?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/utn/utn-prog-3/clases/7_practica_slim");

include_once "./class/response.class.php";
include_once "./class/autenticate.class.php";
include_once "./class/file-data.class.php";
include_once "./class/file-img.class.php";
include_once "./class/bin-data.class.php";
include_once "./class/users.class.php";
include_once "./class/product.class.php";


#region Validar acceso  --------------------------------------------------------------------------------------------------------

$app->post('/usuario', function (Request $request, Response $response) {
    $bodyData = "";
    $status = 201;
    $params = $request->getParsedBody();// para POST & PUT

    if (isset($params['email']) && isset($params['clave']) && isset($params['tipo'])) {
        $auth = Autenticate::signin($params['email'], $params['clave'], $params['tipo']);
        if (!is_int($auth)) {
            $bodyData = ResFac::data2DTO("Success", (object) array("token" => $auth));
        } else if ($auth == 400) {
            $bodyData = ResFac::data2DTO("Error", "Ya existe un usuario con el email " . $params['email']);
            $status = 400;
        } else {
            $bodyData = ResFac::data2DTO("Error", $auth, "No se pudo crear el usuario por un error interno.");
            $status = $auth;
        }
    } else {
        $bodyData = ResFac::data2DTO("Error", 400, "Datos en solicitud incorrectos.");
    }
    $response->getBody()->write($bodyData);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
});

$app->post('/login', function (Request $request, Response $response) {
    $bodyData = "";
    $status = 200;
    $params = $request->getParsedBody();// para POST & PUT

    if (isset($params['email']) && isset($params['clave']) ) {
        $auth = Autenticate::login($params['email'], $params['clave']);
        if (!is_int($auth)) {
            $bodyData = ResFac::data2DTO("Success", (object) array("token" => $auth));
        } else  if ($auth == 401) {
            $bodyData = ResFac::data2DTO("Error", "email o clave incorrecta.");
            $status = 401;
        } else {
            $bodyData = ResFac::data2DTO("Error", "No se pudo crear el usuario por un error interno");
            $status = $auth;
        }
    } else {
        $bodyData = ResFac::data2DTO("Error", "Solicitud incorrecta.");
        $status = 401;
    }
    $response->getBody()->write($bodyData);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
});
#endregion

#region Pizzas  ----------------------------------------------------------------------------------------------------------------

$app->post('/pizzas', function (Request $request, Response $response) {
    $bodyData = "";
    $status = 201;
    $params = $request->getParsedBody();// para POST & PUT

    $jwtData = $request->getheaders()['token'][0] ?? '';
    try {
        $payload = Autenticate::jwtDecode($jwtData);
    } catch (\Throwable $th) {
        $bodyData =ResFac::data2DTO("Error","No autorizado.");
        $status = 401;
    }

    if($status != 401){
        if ($payload->typ == "encargado") {
            if (isset($params['tipo']) && isset($params['precio']) && isset($params['stock']) && isset($params['sabor']) && isset($_FILES['foto'])) {
                if ($params['tipo'] == 'molde' || $params['tipo'] == 'piedra') {
                    if ($params['sabor'] == 'jamón' || $params['sabor'] == 'napo' || $params['sabor'] == 'muzza') {
                        $res = Products::setProduct($params['tipo'], $params['precio'], $params['stock'], $params['sabor'], new FileImg($_FILES['foto']));
                        if (!is_int($res)) {
                            $bodyData = ResFac::data2DTO("Success", $res);
                        } else {
                            $status = $res;
                            switch ($res) {
                                case 400:
                                    $bodyData = ResFac::data2DTO("Error", "El producto ya esta cargado.");
                                    break;
                                default:
                                    $bodyData = ResFac::data2DTO("Error", "No se pudo cargar el producto por un error interno.");
                                    break;
                            }
                        }
                    } else {
                        $bodyData = ResFac::data2DTO("Error", "El tipo sabor ser jamón, napo o muzza, " . $params['sabor'] . " no es valido");
                        $status = 400;
                    }
                } else {
                    $bodyData = ResFac::data2DTO("Error", "El tipo debe ser molde o piedra, " . $params['tipo'] . " no es valido");
                    $status = 400;
                }
            } else {
                $bodyData = ResFac::data2DTO("Error", "Datos en solicitud incorrectos.");
                $status = 400;
            }
        } else {
            $bodyData = ResFac::data2DTO("Error", "No tiene permisos para realizar esta operacion.");
            $status = 403;
        }
    }

    $response->getBody()->write($bodyData);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
});


$app->get('/pizzas', function (Request $request, Response $response, $args) {
    $bodyData = "";
    $status = 200;

    $jwtData = $request->getheaders()['token'][0] ?? '';
    try {
        $payload = Autenticate::jwtDecode($jwtData);
    } catch (\Throwable $th) {
        $bodyData =ResFac::data2DTO("Error","No autorizado.");
        $status = 401;
    }

    if($status != 401){
        $res = Products::getProducts($payload);
        if (!is_int($res)) {
            if (Count($res) > 0) {
                $bodyData = ResFac::data2DTO("Success", $res);
            } else {
                $bodyData = ResFac::data2DTO("Success", $res);
                $status = 204;
            }
        } else {
            $bodyData = ResFac::data2DTO("Error", "Ocurrio un error interno");
            $status = $res;
        }
    }

    $response->getBody()->write($bodyData);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
});
#endregion

#region Ventas  ----------------------------------------------------------------------------------------------------------------


$app->post('/ventas', function (Request $request, Response $response) {
    $bodyData = "";
    $status = 201;
    $params = $request->getParsedBody();// para POST & PUT

    $jwtData = $request->getheaders()['token'][0] ?? '';
    try {
        $payload = Autenticate::jwtDecode($jwtData);
    } catch (\Throwable $th) {
        $bodyData =ResFac::data2DTO("Error","No autorizado.");
        $status = 401;
    }

    if($status != 401){
        if ($payload->typ == "cliente") {
            if (isset($params['tipo']) && isset($params['sabor'])) {

                $res = Products::setSale($params['tipo'], $params['sabor'], $payload->sub);
                if (!is_int($res)) {
                    $bodyData = ResFac::data2DTO("Success", $res);
                } else {
                    $status = $res;
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
                    $bodyData =ResFac::data2DTO("Error", $message);
                }
            } else {
                $bodyData =ResFac::data2DTO("Error", "Datos en solicitud incorrectos.");
                $status = 400;
            }
        } else {
            $bodyData =ResFac::data2DTO("Error", "Los administradores no pueden realizar ventas.");
            $status = 403;
        }
    }

    $response->getBody()->write($bodyData);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
});

$app->get('/ventas', function (Request $request, Response $response, $args) {
    $bodyData = "";
    $status = 200;

    $jwtData = $request->getheaders()['token'][0] ?? '';
    try {
        $payload = Autenticate::jwtDecode($jwtData);
    } catch (\Throwable $th) {
        $bodyData =ResFac::data2DTO("Error","No autorizado.");
        $status = 401;
    }

    if($status != 401){
        
        $res = Products::getSales($payload);
        if (!is_int($res)) {
            if (Count($res) > 0) {
                $bodyData =ResFac::data2DTO("Success", $res);
            } else {
                $bodyData =ResFac::data2DTO("Success", $res);
                $status = 204;
            }
        } else {
            $bodyData =ResFac::data2DTO("Error", "Ocurrio un error interno");
            $status = $res;
        }
    }

    $response->getBody()->write($bodyData);

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
});
#endregion


// Run  -------------------------------------------------------------------------------------------------------------------

$app->run();
