<?php

namespace App\Controllers;

use App\Models\Turnos;
use App\Models\Usuarios;
use App\Models\Mascotas;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TurnosController/* implements iCRUD  */ {
    public function add(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["veterinario_id"]) || !isset($params["mascota_id"]) || !isset($params["fecha"])) {
            throw new RespErrorException("Solicitud incorrecta, debe ingresar veterinario_id, mascota_id y fecha", 400);
        }

        date_default_timezone_set("America/Buenos_Aires");
        $openHour = new DateTime('09:00');
        $closeHour = new DateTime('17:00');
        $today = new DateTime();
        $clientDate = new DateTime($params["fecha"]);
        $clientHour = new DateTime($clientDate->format('H:i'));

        // var_dump([
        //     "openHour" => $openHour->getTimestamp(),
        //     "clientHour" => $clientHour->getTimestamp(),
        //     "closeHour" => $closeHour->getTimestamp(),
        //     "today" => $today->getTimestamp(),
        //     "clientDate" => $clientDate->getTimestamp(),
        // ]);

        // if ($today->getTimestamp() > $clientDate->getTimestamp()) {
        //     throw new RespErrorException("No es posible asignar turnos en fechas pasadas", 400);
        // }
        if ($openHour->getTimestamp() > $clientHour->getTimestamp() || $clientHour->getTimestamp() > $closeHour->getTimestamp()) {
            throw new RespErrorException("Los turnos son de 9 a 17 hs", 400);
        }
        if ($clientHour->format('i') != "30" && $clientHour->format('i') != "00") {
            throw new RespErrorException("Los turnos son cada 30 minutos exactos", 400);
        }
        $user = Usuarios::where('id', $params["veterinario_id"])->first();
        if ($user['tipo'] != 2) {
            throw new RespErrorException("Debe asignar un usuario que sea veterinario para atender a su mascota", 400);
        }
        $registeredShifts = Turnos::where('fecha', $clientDate->format('Y-m-d H:i:s'))
            ->get();
        if ($registeredShifts->count() > 1) {
            throw new RespErrorException("No quedan turnos en ese horario", 400);
        }
        $registeredShifts = Turnos::where('fecha', $clientDate->format('Y-m-d H:i:s'))
            ->where('veterinario_id', $params["veterinario_id"])
            ->get();
        if ($registeredShifts->count() > 0) {
            throw new RespErrorException("El turno para ese veterinario ya esta asignado", 400);
        }

        $turno = new Turnos();
        $turno->mascota_id = $params["mascota_id"];
        $turno->fecha = $clientDate->format('Y-m-d H:i:s');
        $turno->veterinario_id = $params["veterinario_id"];

        $rta = json_encode(["ok" => $turno->save()]);

        return $response;
    }
    public function getAll(Request $request, Response $response) {
        $payload = Autenticate::validateReq($request);
        $user = Usuarios::where('email', $payload->email)->first();

        if ($payload->tipo == 1) /* 1 admin*/ {
            $turnos = $this->getAdminAll($user->id);

        } else if ($payload->tipo == 2) /* 2 vet*/ {
            $turnos = $this->getVetAll($user->id);

        } else /* 3 clientes */{
            $turnos = $this->getClientAll($user->id);
        }
        $rta = $turnos;
        //// $tipo = UsuariosTypes::select('type')->where('id', $payload->tipo)->first();
        //// [
        //     // "user" => [
        //     //     "id" => $user->id,
        //     //     "email" => $payload->email,
        //     //     "type" => $tipo["type"],
        //     //     "typeNum" => $payload->tipo,
        //     // ],
        ////     "turnos" => $turnos,
        //// ];

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function getOne(Request $request, Response $response) {}

    private function getAdminAll($id_user){

        date_default_timezone_set("America/Buenos_Aires");
        $today = new DateTime();
        return "admin";
    }
    private function getVetAll($id_user) {
        date_default_timezone_set("America/Buenos_Aires");
        $today = new DateTime();
        // var_dump($today);
        $turnos = Turnos::select('fecha','mascotas.nombre', 'mascotas.fecha_nacimiento','usuarios.usuario' )
            ->where('fecha', 'LIKE', $today->format('Y-m-d').'%')
            ->join('mascotas', 'turnos.mascota_id', '=', 'mascotas.id')
            ->join('usuarios', 'mascotas.cliente_id', '=', 'usuarios.id')
            ->get();

        return $turnos;
    }

    private function getClientAll($id_user) {
        // fecha del turno, el nombre de la mascota y el nombre del veterinario de todos los turnos de todas sus mascotas
        
        $turnos = Turnos::select('fecha','mascotas.nombre', 'mascotas.fecha_nacimiento','usuarios.usuario' )
            ->join('mascotas', 'turnos.mascota_id', '=', 'mascotas.id')
            ->join('usuarios', 'mascotas.veterinario_id', '=', 'usuarios.id')
            ->get();

        // $mascotas = Mascotas::select('nombre', 'turnos.fecha')
        //     ->where('id_cliente', $id_user)
        //     ->join('usuarios', 'mascotas.id_cliente', '=', 'usuarios.id')
        //     ->join('turnos', 'turnos.id_mascota', '=', 'mascotas.id')
        //     ->get();

        // return $mascotas;
        return "clientes";
    }

}
