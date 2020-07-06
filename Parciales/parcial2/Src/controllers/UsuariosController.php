<?php

namespace App\Controllers;

use App\Models\Usuarios;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuariosController/* implements iCRUD */ {
    /** Crea un nuevo usuario. Retorna un JWT o lanza una excepcion */
    public function register(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["usuario"]) || !isset($params["email"]) || !isset($params["tipo"]) || !isset($params["clave"])) {
            throw new RespErrorException("Solicitud incorrecta", 400);
        }

        $user = new Usuarios();
        $user->usuario = $params["usuario"];
        $user->email = $params["email"];
        $user->tipo = $params["tipo"];
        $user->clave = Autenticate::jwtEncode($params["clave"]);
        // $user->pass = $params["pass"];

        if(!is_numeric($user["tipo"])){
            throw new RespErrorException("Tipo de usuario debe ser un numero", 400);
        }
        if($user["tipo"]< 1 || 3 < $user["tipo"]){
            throw new RespErrorException("Tipo de usuario debe ser 1 (admin), 2(vet) o 3(cliente)", 400);
        }

        try {
            $user->save();
            $payload = [
                "email" => $user["email"],
                "tipo" => $user["tipo"],
            ];
            $jwt = Autenticate::jwtEncode($payload);

            $rta = json_encode(["jwt" => $jwt]);
        } catch (\PDOException $e) {
            // throw new RespErrorException("Solicitud incorrecta", 400, $e);
            throw new RespErrorException($e->getMessage(), 400, $e);
        }

        $response->getBody()->write($rta);
        // $response->getBody()->write("register");
        return $response;
    }

    public function login(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["email"]) || !isset($params["clave"])) {
            throw new RespErrorException("Solicitud incorrecta", 400);
        }

        try {
            $encriptclave = Autenticate::jwtEncode($params["clave"]);
            $user = Usuarios::where('email', $params["email"])
                ->where('clave', $encriptclave)
                ->first();
            if (!$user) {
                throw new RespErrorException("No autorizado.", 401);
            }
            $payload = [
                "email" => $user["email"],
                "tipo" => $user["tipo"],
            ];
            $jwt = Autenticate::jwtEncode($payload);
            $rta = json_encode(["jwt" => $jwt]);

        } catch (\PDOException $e) {
            throw new RespErrorException("Solicitud incorrecta", 400, $e);
        }

        $response->getBody()->write($rta);
        // $response->getBody()->write("login");
        return $response;
    }
}
