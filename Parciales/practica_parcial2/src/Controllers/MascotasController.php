<?php

namespace App\Controllers;

use App\Models\Mascotas;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Utils\iCRUD;

class MascotasController implements iCRUD{    
    
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
}