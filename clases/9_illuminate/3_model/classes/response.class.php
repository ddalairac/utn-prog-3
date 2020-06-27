<?php

use Psr\Http\Message\ResponseInterface as Response;

class Res{

    public static function data2DTO($status, $data, Response $response){
        $body = new stdClass();
        if ($status > 299) {
            $body->status = "Error";
            $body->message = $data;
        } else {
            $body->status = "Success";
            $body->data = $data;
        }
        $body = json_encode($body, JSON_PRETTY_PRINT);

        $response->getBody()->write($body);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
/* 
    200, "ok"
    201, "Creado"
    202, "Aceptado"

    400, "Datos en incorrectos."
    401, "No tiene permisos para realizar esta operacion."
    403, "Prohibido" // como 401 pero loguearse de nuevo no hace diferencia.
    404, "No se encontro"
    405, "Método no permitido."
    409, "Conflicto con recurso" // se quiere modificar un archivo que ya no existe

    500, "Error interno."
*/
