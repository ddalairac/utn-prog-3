<?php

namespace App\Controllers;

use App\Models\P2Mascotas;
use App\Models\P2Turnos;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MascotasController/* implements iCRUD */ {

    public function getOne(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["id"])) {
            throw new RespErrorException("Solicitud incorrecta, debe indicar el id de la mascota", 400);
        }
        $mascota = P2Mascotas::where('id', $params["id"])->first();
        $turnos = P2Turnos::where('id_mascota', $params["id"])
            ->join('p2_usuarios', 'p2_usuarios.id', '=', 'p2_turnos.id_veterinario')
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->select('hora', 'fecha', 'p2_usuarios.email')
            ->get();

        $rta = json_encode([
            "mascota" => $mascota,
            "turnos" => $turnos,
        ]);

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
        $rta = json_encode(["ok" => $mascota->save()]);

        $response->getBody()->write($rta);
        return $response;
    }

}