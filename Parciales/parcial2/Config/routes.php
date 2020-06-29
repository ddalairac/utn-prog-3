<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuariosController;
use App\Controllers\MascotasController;
use App\Controllers\TurnosController;
use App\Middleware\BeforeMiddleware;
use App\Middleware\UppercaseTurnosMiddleware;

return function ($app) {
    // $app->get('/',function (Request $request, Response $response) {
    //     $response->getBody()->write("Hello world!");
    //     return $response;
    // });
    
    $app->post('/registro', UsuariosController::class . ':register');
    $app->post('/login', UsuariosController::class . ':login');
    
    $app->group('/mascota', function (RouteCollectorProxy $group) {
        // $group->get('[/]', MascotasController::class . ":getAll");
        $group->get('/{id_mascota}', MascotasController::class . ":getOne");
        $group->post('[/]', MascotasController::class . ":add");
        // $group->put('[/]', MascotasController::class . ":update");
        // $group->delete('[/]', MascotasController::class . ":delete");
    })->add(new BeforeMiddleware());

    $app->group('/turnos', function (RouteCollectorProxy $group) {
        $group->get('[/]', TurnosController::class . ":getAll")->add(new UppercaseTurnosMiddleware());
        // $group->get('/{id}', TurnosController::class . ":getOne");
        $group->post('[/mascota]', TurnosController::class . ":add");
        // $group->put('[/]', TurnosController::class . ":update");
        // $group->delete('[/]', TurnosController::class . ":delete");
    })->add(new BeforeMiddleware());
};
