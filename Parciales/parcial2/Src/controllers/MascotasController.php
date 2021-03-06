<?php

namespace App\Controllers;

use App\Models\Mascotas;
use App\Models\Turnos;
use App\Models\Usuarios;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MascotasController/* implements iCRUD */ {

    public function add(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["nombre"]) || !isset($params["fecha_nacimiento"]) || /* !isset($params["cliente_id"]) || */ !isset($params["tipo_mascota_id"])) {
            throw new RespErrorException("Solicitud incorrecta, debe ingresar nombre, fecha, dueño y tipo", 400);
        }
        if (Autenticate::validateReq($request)->tipo != 3) /* 3 clientes*/ {
            throw new RespErrorException("Solo los clientes pueden dar de alta mascotas", 401);
        }
        $payload = Autenticate::validateReq($request);
        $user = Usuarios::where('email', $payload->email)->first();

        try {
            $mascota = new Mascotas();
            $mascota->nombre = $params["nombre"];
            $mascota->fecha_nacimiento = $params["fecha_nacimiento"];
            $mascota->cliente_id = $user->id;//$params["cliente_id"];
            $mascota->tipo_mascota_id = $params["tipo_mascota_id"];
            $rta = json_encode(["ok" => $mascota->save()]);
        } catch (\PDOException $ex) {
            throw new RespErrorException("Solicitud incorrecta, es posible que tipo de mascota ingresado no exista en la base", 400, $ex);
        }

        $response->getBody()->write($rta);
        return $response;
    }

}