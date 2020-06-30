<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuariosController;
use App\Controllers\MascotasController;
use App\Controllers\TurnosController;
use App\Controllers\TipoMascotaControler;
use App\Middleware\BeforeMiddleware;
use App\Middleware\UppercaseTurnosMiddleware;

return function ($app) {    
    $app->post('/registro', UsuariosController::class . ':register');
    $app->post('/login', UsuariosController::class . ':login');
    
    $app->post('/tipo_mascota', TipoMascotaControler::class . ':add')->add(new BeforeMiddleware());
    $app->post('/mascota', MascotasController::class . ':add')->add(new BeforeMiddleware());
    $app->group('/turnos', function (RouteCollectorProxy $group) {
         $group->get('/{id_usuario}', TurnosController::class . ":getAll")->add(new UppercaseTurnosMiddleware());
        $group->get('/mascota/{id_mascota}', TurnosController::class . ":getOne");
        $group->post('[/mascota]', TurnosController::class . ":add");
    })->add(new BeforeMiddleware());
};
