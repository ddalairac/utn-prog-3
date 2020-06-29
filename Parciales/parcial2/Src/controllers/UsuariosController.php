<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\P2Usuarios;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;

class UsuariosController/* implements iCRUD */ {
    /** Crea un nuevo usuario. Retorna un JWT o lanza una excepcion */
    public function register(Request $request, Response $response) {
        $params = $request->getParsedBody() ?? [];
        if (!isset($params["email"]) || !isset($params["type"]) || !isset($params["pass"])) {
            throw new RespErrorException("Solicitud incorrecta", 400);
        }

        $user = new P2Usuarios();
        $user->email = $params["email"];
        $user->type = $params["type"];
        $user->pass = Autenticate::jwtEncode($params["pass"]);
        // $user->pass = $params["pass"];

        try {
            $rta = json_encode(["jwt" => Autenticate::jwtCreate($user->email, $user->type)]);
            $user->save();
        } catch (\PDOException $e) {
            throw new RespErrorException("Solicitud incorrecta", 400, $e);
        }

        $response->getBody()->write($rta);
        // $response->getBody()->write("register");
        return $response;
    }

    public function login(Request $request, Response $response) {
        $params = $request->getParsedBody()??[];
        if (!isset($params["email"]) || !isset($params["pass"])) {
            throw new RespErrorException("Solicitud incorrecta", 400);
        }

        try {
            $encriptPass = Autenticate::jwtEncode($params["pass"]);
            $user = P2Usuarios::where('email', $params["email"])
                ->where('pass', $encriptPass)
                ->first();
            if(!$user){
                throw new RespErrorException("No autorizado.", 401);
            }
            $payload = [
                "email" => $user["email"], 
                "type" =>$user["type"],
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

    // public function getAll(Request $request, Response $response) {
    //     $response->getBody()->write("getAll usuarios");
    //     return $response;
    // }
    // public function getOne(Request $request, Response $response) {
    //     $response->getBody()->write("getOne usuario");
    //     return $response;
    // }
    // public function add(Request $request, Response $response) {
    //     $response->getBody()->write("add usuario");
    //     return $response;
    // }
    // public function update(Request $request, Response $response) {
    //     $response->getBody()->write("update usuario");
    //     return $response;
    // }
    // public function delete(Request $request, Response $response) {
    //     $response->getBody()->write("delete usuario");
    //     return $response;
    // }
}
