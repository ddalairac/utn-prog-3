<?php

use App\Controllers\AlumnoController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {
    $app->get('[/]', function (Request $request, Response $response) {
        $response->getBody()->write("Hello world!");
        return $response;
    });
    $app->group('[/mascota]', function () {
        $this->get('[/]', AlumnoController::class . "getAll");
        $this->get('[/{id}]', AlumnoController::class . "getOne");
        $this->post('[/]', AlumnoController::class . "add");
        $this->put('[/]', AlumnoController::class . "update");
        $this->delete('[/]', AlumnoController::class . "delete");
    });
};
