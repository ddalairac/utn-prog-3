<?php

// use App\Controllers\AlumnosController;
// use App\Middleware\BeforeMiddleware;
use Slim\Routing\RouteCollectorProxy;

// use App\Middleware\AfterMiddleware;
// use App\Middleware\AlumnoValidateMiddleware;

return function ($app) {
    // $app->get('[/]', function (Request $request, Response $response) {
    //     $response->getBody()->write("Hello world!");
    //     return $response;
    // });
    $app->post('/registro', UsuariosController::class . ':register');
    $app->post('/login', UsuariosController::class . ':login');

    // $app->group('/usuarios', function (RouteCollectorProxy $group) {
    //     $group->get('[/]', UsuariosController::class . ':getAll');
    //     $group->get('/:id', UsuariosController::class . ':getOne');
    //     // $group->post('[/]', UsuariosController::class . ':add')->add(AlumnoValidateMiddleware::class);
    //     // $group->put('/:id', UsuariosController::class . ':update')->add(AlumnoValidateMiddleware::class);
    //     $group->delete('/:id', UsuariosController::class . ':delete');
    // })->add(new BeforeMiddleware());

    // $app->group('/mascotas', function (RouteCollectorProxy $group) {
    //     $group->get('[/]', MascotasController::class . ':getAll');
    //     $group->get('/:id', MascotasController::class . ':getOne');
    //     $group->post('[/]', MascotasController::class . ':add');
    //     $group->put('/:id', MascotasController::class . ':update');
    //     $group->delete('/:id', MascotasController::class . ':delete');
    // });

    // $app->group('/turnos', function (RouteCollectorProxy $group) {
    //     $group->get('[/]', MascotasController::class . ':getAll');
    //     $group->get('/:id', MascotasController::class . ':getOne');
    //     $group->post('[/]', MascotasController::class . ':add');
    //     $group->put('/:id', MascotasController::class . ':update');
    //     $group->delete('/:id', MascotasController::class . ':delete');
    // });
};