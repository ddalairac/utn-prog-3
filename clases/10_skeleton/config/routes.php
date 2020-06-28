<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use slim\Routing\RouteCollectorProxy;
use App\Controllers\AlumnoController;
use App\Middleware\BeforeMiddleware;

return function ($app) {
    $app->get('/',          function (Request $request, Response $response) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
    $app->group('/alumnos', function (RouteCollectorProxy $group) {
        $group->get('[/]', AlumnoController::class . ":getAll");
        // $group->get('[/{id}]', AlumnoController::class . ":getOne");
        $group->post('[/]', AlumnoController::class . ":add");
        $group->put('[/]', AlumnoController::class . ":update");
        $group->delete('[/]', AlumnoController::class . ":delete");
    })->add(new BeforeMiddleware());;
};
