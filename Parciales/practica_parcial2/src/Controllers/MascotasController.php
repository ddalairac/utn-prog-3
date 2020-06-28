<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\P2Mascotas;
use App\Models\P2Turnos;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;

class MascotasController/* implements iCRUD */ {

    // public function getAll(Request $request, Response $response) {
    //     $response->getBody()->write("getAll mascotas");
    //     return $response;
    // }
    public function getOne(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["id"])) {
            throw new RespErrorException("Solicitud incorrecta, debe indicar el id de la mascota", 400);
        }
        // try {
            $mascota = P2Mascotas::where('id', $params["id"])
                ->first();

            $turnos = P2Turnos::where('id_mascota', $params["id"])
                ->get();
            $rta = json_encode([
                "mascota" => $mascota,
                "turnos" => $turnos
            ]);
        // } catch (\Throwable $th) {
        //     throw new RespErrorException($th->getMessage(), 400);
        // }

        $response->getBody()->write($rta);
        return $response;
    }

    public function add(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["nombre"]) || !isset($params["edad"])) {
            throw new RespErrorException("Solicitud incorrecta, debe ingresar nombre y edad", 400);
        }
        if (Autenticate::validateReq($request)->type != 1) /* 1 clientes*/ {
            throw new RespErrorException("Solo los clientes pueden dar de alta mascotas", 401);
        }

        $mascota = new P2Mascotas();
        $mascota->nombre = $params["nombre"];
        $mascota->edad = $params["edad"];
        $mascota->id_cliente = 1;
        try {
            $rta = json_encode(["ok" => $mascota->save()]);
        } catch (\PDOException $e) {
            throw new RespErrorException("Solicitud incorrecta", 400, $e);
        }

        $response->getBody()->write($rta);
        return $response;
    }

    // public function update(Request $request, Response $response) {
    //     $response->getBody()->write("update mascota");
    //     return $response;
    // }
    // public function delete(Request $request, Response $response) {
    //     $response->getBody()->write("delete mascota");
    //     return $response;
    // }
}