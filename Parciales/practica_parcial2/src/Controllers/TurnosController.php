<?php

namespace App\Controllers;

use App\Models\P2Turnos;
use App\Utils\RespErrorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TurnosController/* implements iCRUD  */ {
    // public function getAll(Request $request, Response $response) {
    //     $response->getBody()->write("getAll turnos");
    //     return $response;
    // }
    // public function getOne(Request $request, Response $response) {
    //     $response->getBody()->write("getOne turno");
    //     return $response;
    // }
    public function add(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["id_mascota"]) || !isset($params["fecha"]) || !isset($params["hora"]) || !isset($params["id_veterinario"])) {
            throw new RespErrorException("Solicitud incorrecta, debe ingresar nombre y edad", 400);
        }
        $turno = new P2Turnos();

        $response->getBody()->write("add turno");
        return $response;
    }

    // public function update(Request $request, Response $response) {
    //     $response->getBody()->write("update turno");
    //     return $response;
    // }
    // public function delete(Request $request, Response $response) {
    //     $response->getBody()->write("delete turno");
    //     return $response;
    // }
}
