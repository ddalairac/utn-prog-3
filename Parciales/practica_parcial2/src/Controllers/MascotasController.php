<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\P2Mascotas;
use App\Utils\iCRUD;
use App\Utils\Autenticate;
use App\Utils\RespErrorException;

class MascotasController /* implements iCRUD */{    
    
    // public function getAll(Request $request, Response $response) {
    //     $response->getBody()->write("getAll mascotas");
    //     return $response;
    // }
    public function getOne(Request $request, Response $response) {
        
        $response->getBody()->write("getOne mascota");
        return $response;
    }
    public function add(Request $request, Response $response) {
        $params = $request->getParsedBody()??[];
        if (!isset($params["nombre"]) || !isset($params["edad"])) {
            throw new RespErrorException("Solicitud incorrecta", 400);
        }
        if(Autenticate::getUser($request)->type != 1){// 1 clientes
            throw new RespErrorException("Solo los clientes pueden dar de alta mascotas", 401);
        }
        
        $mascota = new P2Mascotas();
        $mascota->nombre = $params["nombre"];
        $mascota->edad = $params["edad"];
        $mascota->id_cliente = 1;
        try {
            $rta =json_encode(["ok" => $mascota->save() ]);
        } catch (\PDOException $e) {
            throw new RespErrorException("Solicitud incorrecta", 400, $e);
        }

        $response->getBody()->write("add mascota");
        return $response;
    }
    // public function update(Request $request, Response $response) {
    //     $response->getBody()->write("update mascota");
    //     return $response;
    // }
    // public function delete(Request $request, Response $response) {
    //     $response->getBody()->write("delete mascota");
    //     return $response;
    // }
}