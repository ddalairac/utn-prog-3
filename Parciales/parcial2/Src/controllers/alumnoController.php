<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
// use App\Models\Alumno;
use App\Models\SkAlumno;
class AlumnoController{
    
    public function getAll(Request $request, Response $response){
        $rta = json_encode(SkAlumno::all());

        $response->getBody()->write($rta);
        return $response;
    }

    public function getOne(Request $request, Response $response){
        $response->getBody()->write("getOne!");
        return $response;
    }
    
    public function add(Request $request, Response $response){
        $alumno = new SkAlumno();
        $alumno->nombre = "Manson";
        $alumno->dni = 123456789;
        $alumno->promedio = 6 ;

        
        $rta = json_encode(array("ok"=>$alumno->save()));

        $response->getBody()->write($rta);
        return $response;
    }
    
    public function update(Request $request, Response $response){
        $response->getBody()->write("update!");
        return $response;
    }
    
    public function delete(Request $request, Response $response){
        $response->getBody()->write("delete!");
        return $response;
    }
}