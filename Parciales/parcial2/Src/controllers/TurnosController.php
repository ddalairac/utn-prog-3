<?php

namespace App\Controllers;

use App\Models\Mascotas;
use App\Models\Turnos;
use App\Models\Usuarios;
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
        try {
            $clientDate = new DateTime($params["fecha"]);
            $clientHour = new DateTime($clientDate->format('H:i'));
        } catch (\Throwable $th) {
            throw new RespErrorException("Error en el formato de fecha (yyyy-mm-dd hh:mm)", 400);
        }

        // var_dump([
        //     "openHour" => $openHour->getTimestamp(),
        //     "clientHour" => $clientHour->getTimestamp(),
        //     "closeHour" => $closeHour->getTimestamp(),
        //     "today" => $today->getTimestamp(),
        //     "clientDate" => $clientDate->getTimestamp(),
        // ]);

        if ($today->getTimestamp() > $clientDate->getTimestamp()) {
            throw new RespErrorException("No es posible asignar turnos en fechas pasadas", 400);
        }
        if ($openHour->getTimestamp() > $clientHour->getTimestamp() || $clientHour->getTimestamp() > $closeHour->getTimestamp()) {
            throw new RespErrorException("Los turnos son de 9 a 17 hs", 400);
        }
        if ($clientHour->format('i') != "30" && $clientHour->format('i') != "00") {
            throw new RespErrorException("Los turnos son cada 30 minutos exactos", 400);
        }
        $user = Usuarios::where('id', $params["veterinario_id"])->first();
        if ($user['tipo'] != 2) /* 2 veterinario */ {
            throw new RespErrorException("Debe asignar un usuario que sea veterinario para atender a su mascota", 400);
        }
        $mascotaParaElTurno = Mascotas::where('id', $params["mascota_id"])->first();
        if (!$mascotaParaElTurno || $mascotaParaElTurno->count() == 0) {
            throw new RespErrorException("No se encontraron mascotas que correspondan al id ingresado", 400);
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

        try {
            $turno = new Turnos();
            $turno->mascota_id = $params["mascota_id"];
            $turno->fecha = $clientDate->format('Y-m-d H:i:s');
            $turno->veterinario_id = $params["veterinario_id"];

            $rta = json_encode(["ok" => $turno->save()]);
        } catch (\PDOException $ex) {
            throw new RespErrorException("Solicitud incorrecta", 400, $ex);
        }

        $response->getBody()->write($rta);
        return $response;
    }
    public function getAll(Request $request, Response $response, $params) {

        // ? usando datos de id usuario url
        if (!is_numeric($params['id_usuario'])) {
            throw new RespErrorException("El id de usuario debe ser numérico ", 400);
        }
        $usuarioTurnos = Usuarios::where('id', $params['id_usuario'])->first();
        if (!$usuarioTurnos || $usuarioTurnos->count() == 0) {
            throw new RespErrorException("No se encontraron usuarios que correspondan al id " . $params['id_usuario'], 400);
        }
        $idUsuario = $usuarioTurnos->id;
        $tipoUsuario = $usuarioTurnos->tipo;

        // ? usando datos de usuario logueado
        // $payload = Autenticate::validateReq($request);
        // $tipoUsuario = $payload->tipo;
        // $usuarioTurnos = Usuarios::where('email', $payload->email)->first();
        // $idUsuario = $usuarioTurnos->id;

        if ($tipoUsuario == 1) /* 1 admin*/ {
            $rta = $this->getAdminAll($usuarioTurnos);

        } else if ($tipoUsuario == 2) /* 2 vet*/ {
            $rta = $this->getVetAll($usuarioTurnos);

        } else /* 3 clientes */{
            $rta = $this->getClientAll($usuarioTurnos);
        }

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function getOne(Request $request, Response $response, $params) {
        // Historial de atención mascota, nombre mascota, edad, fecha todas las visitas, nombre veterinario
        if (!is_numeric($params['id_mascota'])) {
            throw new RespErrorException("El id de la mascota debe ser numérico ", 400);
        }
        $mascotaTurnos = Mascotas::select('mascotas.nombre', 'mascotas.fecha_nacimiento', 'tipo_mascota.tipo' )
            ->where('mascotas.id', $params['id_mascota'])
            ->join('tipo_mascota', 'mascotas.tipo_mascota_id', '=', 'tipo_mascota.id')
            // ->orderBy('fecha', 'desc')
            ->first();
        if (!$mascotaTurnos || $mascotaTurnos->count() == 0) {
            throw new RespErrorException("No se encontraron mascotas que correspondan al id " . $params['id_mascota'], 400);
        }
        
        date_default_timezone_set("America/Buenos_Aires");
        $today = new DateTime();
        $turnos = Turnos::select('fecha','usuarios.usuario as veterinario')
            ->where('mascota_id', $params['id_mascota'])
            ->whereDate('fecha','<', $today->format('Y-m-d'))
            ->join('usuarios','turnos.veterinario_id','=','usuarios.id')
            ->orderBy('fecha', 'desc')
            ->get();
        // print_r($mascotaTurnos);
        $rta = [
            "mascota" =>$mascotaTurnos,
            "historial" => $turnos,
        ];
        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    private function getAdminAll($user) {
        return [
            "usuario" => $user->usuario,
            "tipo" => "admin",
            // "turnos" => null,
        ];
    }
    private function getVetAll($user) {
        // turnos del día con: nombre mascota, hora, fecha, nombre dueño y edad mascota.
        date_default_timezone_set("America/Buenos_Aires");
        $today = new DateTime();
        $turnos = Turnos::select('fecha', 'mascotas.nombre', 'mascotas.fecha_nacimiento', 'usuarios.usuario as dueño')
            ->whereDate('fecha', $today->format('Y-m-d'))
            ->join('mascotas', 'turnos.mascota_id', '=', 'mascotas.id')
            ->join('usuarios', 'mascotas.cliente_id', '=', 'usuarios.id')
            ->orderBy('fecha', 'desc')
            ->get();

        return [
            "usuario" => $user->usuario,
            "tipo" => "Veterinario",
            "turnos" => $turnos,
        ];
    }

    private function getClientAll($user) {
        // fecha del turno, el nombre de la mascota y el nombre del veterinario de todos los turnos de todas sus mascotas
        $turnos = Turnos::select('fecha', 'mascotas.nombre', 'mascotas.fecha_nacimiento', 'usuarios.usuario as veterinario')
            ->where('mascotas.cliente_id', $user->id)
            ->join('mascotas', 'turnos.mascota_id', '=', 'mascotas.id')
            ->join('usuarios', 'veterinario_id', '=', 'usuarios.id')
            ->orderBy('fecha', 'desc')
            ->get();
        return [
            "usuario" => $user->usuario,
            "tipo" => "Cliente",
            "turnos" => $turnos,
        ];
    }

}
