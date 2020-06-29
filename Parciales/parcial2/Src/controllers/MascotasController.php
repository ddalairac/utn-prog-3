<?php

namespace App\Controllers;

use App\Models\P2Mascotas;
use App\Models\P2Turnos;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MascotasController/* implements iCRUD */ {

    public function getOne(Request $request, Response $response,$param) {
        
        if(!is_numeric($param['id_mascota'])){
            throw new RespErrorException("El id de la mascota debe ser numerico", 400);
        }
        // $params = $request->getParsedBody() ?? [];

        $mascota = P2Mascotas::where('id', $param['id_mascota'])->first();
        if(!$mascota){
            throw new RespErrorException("El id ingresado no corresponde a ninguna mascota", 400);
        }
        $turnos = P2Turnos::where('id_mascota', $param['id_mascota'])
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