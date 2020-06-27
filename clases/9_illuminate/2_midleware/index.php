<?php

// ? set Slim
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/vendor/autoload.php';
require './config/capsule.php';
require './classes/response.class.php';

// ? set Slim
$app = AppFactory::create();
$app->setBasePath("/utn/utn-prog-3/clases/9_illuminate");


$app->get('/', function (Request $request, Response $response) {
    $data = Capsule::table('envios')->get(); // ? trae todo

    return Res::data2DTO(200, $data, $response);
    // $response->getBody()->write(json_encode($data));
    // return $response
    //     ->withHeader('Content-Type', 'application/json')
    //     ->withStatus(200);
});

$app->get('/first', function (Request $request, Response $response) {
    $data = Capsule::table('envios')
        ->select(['Numero', 'pNumero', 'Cantidad'])
        ->where('pNumero', '>', 2)
        ->first(); //? SIN  usar ->get(); 

    return Res::data2DTO(200, $data, $response);
});


$app->get('/distinct', function (Request $request, Response $response) {
    $data = Capsule::table('envios')
    ->select(['Numero'])
    ->distinct()->get();

    return Res::data2DTO(200, $data, $response);
});



$app->get('/where', function (Request $request, Response $response) {
    $data = Capsule::table('envios')
        ->select(['Numero', 'pNumero', 'Cantidad'])
        ->where('pNumero', '>', 1)
        ->orWhere('pNumero','<', 3)
        // ->AndWhere('pNumero','<', 3)
        ->get();

    return Res::data2DTO(200, $data, $response);
});

$app->get('/join', function (Request $request, Response $response) {
    $data = Capsule::table('envios')
        ->join('productos', 'productos.pNumero', '=', 'envios.pNumero')
        // ->join('provedores', 'provedores.Numero', '=', 'envios.Numero')
        ->get();

    return Res::data2DTO(200, $data, $response);
});

$app->run();
