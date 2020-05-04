<?php
class Response{
    public static $response;
    // public function __constructor($status,$data){
    public function data2DTO($status,$code,$data){
        self::$response = new stdClass();
        self::$response->status = $status;
        self::$response->code = $code;
        if($status == "Error"){
            self::$response->message = $data;
        } else {
            self::$response->data = $data;
        }
        return json_encode(self::$response, JSON_PRETTY_PRINT);
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
?>