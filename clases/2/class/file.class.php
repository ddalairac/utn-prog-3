<?php
class File {

    public function __constructor(){}
    private static $filerute = './files/';
    private static $filename= 'file.txt';
    private function toDTO($data){
        return json_encode($data, JSON_PRETTY_PRINT);
    }
    private function txtToObj($str){
        $personaArr = explode(',', $str);
        $personaObj = new stdClass();//create a new
        $personaObj->id = $personaArr[0];
        $personaObj->nombre = str_replace("\r\n","",$personaArr[1]);

        return $personaObj;
    }
    public function readAll(){
        $result = [];
        try {
            $archivo = fopen(self::$filerute.self::$filename,'r');
            // $result = fread($archivo,filesize(self::$filerute)); // lee todo el archivo hasta el limite de bytes
            while(!feof($archivo)){ // itera hasta que termina el archivo
                $row = fgets($archivo); // lee una linea
                array_push($result, $this->txtToObj($row));
            }
            $archivo = fclose($archivo);
        } catch (\Throwable $th) {
            $result = $th;
        }
        return $this->toDTO($result);
    }
    public function readByID($requestId){
        $result = "";
        try {
            $archivo = fopen(self::$filerute.self::$filename,'r');
            while(!feof($archivo)){ // itera hasta que termina el archivo
                $row = fgets($archivo); // lee una linea
                $persona = $this->txtToObj($row);

                if($persona->id == $requestId){
                    $persona->requestId =$requestId;
                    $result = $persona;
                    break;
                }
            }
            $archivo = fclose($archivo);
        } catch (\Throwable $th) {
            $result = $th->getMessage();
        }
        return $this->toDTO($result);
    }
    public function write($data){
        try {
            $archivo = fopen(self::$filerute.self::$filename,'a+');
            fwrite($archivo, $data); // va a depender de como abrimos el archivo
            $archivo = fclose($archivo);
        } catch (\Throwable $th) {
            $result = $th;
        }
    }
    public function delete($deleteId){
        // $result = "";
        // try {
        //     $archivo = fopen(self::$filerute.self::$filename,'r');
        //     while(!feof($archivo)){ // itera hasta que termina el archivo
        //         $row = fgets($archivo); // lee una linea
        //         $persona = $this->txtToObj($row);

        //         if($persona->id == $requestId){
        //             $persona->requestId =$requestId;
        //             $result = $persona;
        //             break;
        //         }
        //     }
        //     $archivo = fclose($archivo);
        // } catch (\Throwable $th) {
        //     $result = $th;
        // }
        // return $this->toDTO($result);
    }
    public function overWrite($data){
        try {
            $archivo = fopen(self::$filerute.self::$filename,'w');
            fwrite($archivo, $data); // va a depender de como abrimos el archivo
            $archivo = fclose($archivo);
        } catch (\Throwable $th) {
            $result = $th;
        }
    }
    public function backup(){
        try {
            copy(self::$filerute.self::$filename,self::$filerute.'file2.txt');
        } catch (\Throwable $th) {
            $result = $th;
        }
    }
}
/* 

fwrite($archivo, "nueva linea"); // va a depender de como abrimos el archivo
fwrite($archivo, PHP_EOL); // va a depender de como abrimos el archivo
fput($archivo, "nueva linea"); // googlear

$archivo = fclose($archivo);

copy('file.txt','file2.txt');
unlink('file2.txt'); // borra el archivo
 */
?>
