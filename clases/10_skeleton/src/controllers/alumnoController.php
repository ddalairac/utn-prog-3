<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlumnoController{
    
    public function getAll(Request $request, Response $response){
        $response->getBody()->write("Hello getAll!");
        return $response;
    }

    public function getOne(Request $request, Response $response){
        $response->getBody()->write("Hello getOne!");
        return $response;
    }
    
    public function add(Request $request, Response $response){
        $response->getBody()->write("Hello insert!");
        return $response;
    }
    
    public function update(Request $request, Response $response){
        $response->getBody()->write("Hello update!");
        return $response;
    }
    
    public function delete(Request $request, Response $response){
        $response->getBody()->write("Hello world!");
        return $response;
    }
}