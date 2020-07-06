<?php
namespace App\Utils;
use Exception;

class RespErrorException extends Exception
{
    // Redefinir la excepción, por lo que el mensaje no es opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // algo de código
    
        // asegúrese de que todo está asignado apropiadamente
        parent::__construct($message, $code, $previous);
    }

    // representación de cadena personalizada del objeto
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function funciónPersonalizada() {
        echo "Una función personalizada para este tipo de excepción\n";
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