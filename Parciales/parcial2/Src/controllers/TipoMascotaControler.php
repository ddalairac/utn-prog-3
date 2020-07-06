<?php

namespace App\Controllers;

use App\Models\TipoMascota;
use App\Models\Turnos;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TipoMascotaControler/* implements iCRUD */ {

    public function add(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["tipo"])) {
            throw new RespErrorException("Solicitud incorrecta, debe ingresar un tipo de mascota", 400);
        }
        // var_dump(Autenticate::validateReq($request));
        $userType = Autenticate::validateReq($request)->tipo;
        // echo $userType;
        if ($userType != 1) /* 1 admin*/ {
            throw new RespErrorException("Solo los admin pueden ingresar un tipo de mascota", 401);
        }
        try {
            $mascota = new TipoMascota();
            $mascota->tipo = $params["tipo"];
            $rta = json_encode(["ok" => $mascota->save()]);
        } catch (\PDOException $ex) {
            throw new RespErrorException("El tipo de mascota '".$params["tipo"]."' ya existe", 400,$ex);
        }


        $response->getBody()->write($rta);
        return $response;
    }

}