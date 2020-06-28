<?php

namespace App\Controllers;

use App\Utils\iCRUD;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuariosController implements iCRUD {
    public function register(Request $request, Response $response) {
        $response->getBody()->write("register");
        return $response;
    }
    public function login(Request $request, Response $response) {
        $response->getBody()->write("login");
        return $response;
    }


    
    public function getAll(Request $request, Response $response) {
        $response->getBody()->write("getAll");
        return $response;
    }
    public function getOne(Request $request, Response $response) {
        $response->getBody()->write("getOne");
        return $response;
    }
    public function add(Request $request, Response $response) {
        $response->getBody()->write("add");
        return $response;
    }
    public function update(Request $request, Response $response) {
        $response->getBody()->write("update");
        return $response;
    }
    public function delete(Request $request, Response $response) {
        $response->getBody()->write("delete");
        return $response;
    }
    
    // public function getAll(Request $request, Response $response, $args)
    // {
    //     $rta = json_encode(Usuarios::all());

    //     // $response->getBody()->write("Controller");
    //     $response->getBody()->write($rta);

    //     return $response;
    // }

    // public function add(Request $request, Response $response, $args)
    // {
    //     $usuario = new Usuarios;
    //     // $usuario->id = "Eloquent";
    //     $usuario->email = 4201;
    //     $usuario->type = 2;
    //     $usuario->pass = 1;

    //     $rta = json_encode(array("ok" => $usuario->save()));

    //     $response->getBody()->write($rta);

    //     return $response;
    // }

}
