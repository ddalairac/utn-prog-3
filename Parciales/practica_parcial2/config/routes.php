<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AlumnosController;
use App\Middleware\BeforeMiddleware;
use App\Middleware\AlumnoValidateMiddleware;


return function ($app) {
    // $app->get('[/]', function (Request $request, Response $response) {
    //     $response->getBody()->write("Hello world!");
    //     return $response;
    // });
    $app->post('/registro', UsuariosController::class . ':register');
    $app->post('/login', UsuariosController::class . ':login');
    
    $app->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('[/]', AlumnosController::class . ':getAll');
        $group->get('/:id', AlumnosController::class . ':getOne');
        $group->post('[/]', AlumnosController::class . ':add')->add(AlumnoValidateMiddleware::class);
        $group->put('/:id', AlumnosController::class . ':update')->add(AlumnoValidateMiddleware::class);
        $group->delete('/:id', AlumnosController::class . ':delete');
    })->add(new BeforeMiddleware());

    $app->group('/mascotas', function (RouteCollectorProxy $group) {
        $group->get('[/]', AlumnosController::class . ':getAll');
        $group->get('/:id', AlumnosController::class . ':getAll');
        $group->post('[/]', AlumnosController::class . ':getAll');
        $group->put('/:id', AlumnosController::class . ':getAll');
        $group->delete('/:id', AlumnosController::class . ':getAll');
    });

    
    $app->group('/turnos', function (RouteCollectorProxy $group) {
        $group->get('[/]', AlumnosController::class . ':getAll');
        $group->get('/:id', AlumnosController::class . ':getAll');
        $group->post('[/]', AlumnosController::class . ':getAll');
        $group->put('/:id', AlumnosController::class . ':getAll');
        $group->delete('/:id', AlumnosController::class . ':getAll');
    });
};