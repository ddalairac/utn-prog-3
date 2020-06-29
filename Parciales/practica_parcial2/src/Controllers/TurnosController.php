<?php

namespace App\Controllers;

use App\Models\P2Mascotas;
use App\Models\P2Turnos;
use App\Models\P2Usuarios;
use App\Models\P2UsuariosTypes;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TurnosController/* implements iCRUD  */ {
    public function getAll(Request $request, Response $response) {
        $payload = Autenticate::validateReq($request);
        $user = P2Usuarios::where('email', $payload->email)->first();
        if ($payload->type == 1) /* 1 clientes*/ {
            $turnos = $this->getClientAll($user->id);
        } else {
            $turnos = $this->getVetAll($user->id);
        }
        $rta = $turnos;
        //// $tipo = P2UsuariosTypes::select('type')->where('id', $payload->type)->first();
        //// [
        //     // "user" => [
        //     //     "id" => $user->id,
        //     //     "email" => $payload->email,
        //     //     "type" => $tipo["type"],
        //     //     "typeNum" => $payload->type,
        //     // ],
        ////     "turnos" => $turnos,
        //// ];

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function add(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["id_mascota"]) || !isset($params["fecha"]) || !isset($params["hora"]) || !isset($params["id_veterinario"])) {
            throw new RespErrorException("Solicitud incorrecta, debe ingresar nombre y edad", 400);
        }

        date_default_timezone_set("America/Buenos_Aires");
        $openHour = new DateTime('09:00');
        $closeHour = new DateTime('17:00');
        $today = new DateTime();
        $clientHour = new DateTime($params['hora']);
        $clientDate = new DateTime($params['fecha'] . " " . $params['hora']);

        if ($today->getTimestamp() > $clientDate->getTimestamp()) {
            throw new RespErrorException("No es posible asignar turnos en fechas pasadas", 400);
        }
        if ($openHour->getTimestamp() > $clientHour->getTimestamp() || $clientHour->getTimestamp() > $closeHour->getTimestamp()) {
            throw new RespErrorException("Los turnos son de 9 a 17 hs", 400);
        }
        if ($clientHour->format('i') != "30" && $clientHour->format('i') != "00") {
            throw new RespErrorException("Los turnos son cada 30 minutos exactos", 400);
        }
        $user = P2Usuarios::where('id', $params["id_veterinario"])->first();
        if ($user['type'] != 2) {
            throw new RespErrorException("Debe asignar un usuario que sea veterinario para atender a su mascota", 400);
        }
        $registeredShifts = P2Turnos::where('fecha', $params["fecha"])
            ->where('hora', $params["hora"])
            ->where('id_veterinario', $params["id_veterinario"])
            ->get();

        if ($registeredShifts->count() > 0) {
            throw new RespErrorException("El turno ya esta asignado", 400);
        }

        $turno = new P2Turnos();
        $turno->id_mascota = $params["id_mascota"];
        $turno->fecha = $params["fecha"];
        $turno->hora = $params["hora"];
        $turno->id_veterinario = $params["id_veterinario"];

        $rta = json_encode(["ok" => $turno->save()]);
        $response->getBody()->write($rta);

        // $response->getBody()->write("add turno");
        return $response;
    }

    private function getVetAll($id_user) {
        $today = new DateTime();
        $turnos = P2Turnos::select('fecha', 'hora', 'p2_mascotas.nombre')
            ->where('id_veterinario', $id_user)
            ->where('fecha', $today->format('Y-m-d'))
            ->join('p2_mascotas', 'p2_turnos.id_mascota', '=', 'p2_mascotas.id')
            ->get();

        return $turnos;
    }

    private function getClientAll($id_user) {
        $mascotas = P2Mascotas::select('nombre', 'p2_turnos.fecha', 'p2_turnos.hora')
            ->where('id_cliente', $id_user)
            ->join('p2_usuarios', 'p2_mascotas.id_cliente', '=', 'p2_usuarios.id')
            ->join('p2_turnos', 'p2_turnos.id_mascota', '=', 'p2_mascotas.id')
            ->get();

        return $mascotas;
    }

}
