<?php
class FileData {

    // public function __constructor(){}
    private static $filerute = './files/';
    private static $filename = 'personas.json';

    public function __construct(){
    }

    public function file2Obj(){
        $jsonData = $this->file2Json();
        $obj = json_decode($jsonData); 
        return $obj; 
    }
    
    public function file2Json(){
        $url = self::$filerute.self::$filename;
        $file = fopen($url, "r");
        $jsonData = fread($file, filesize(self::$filerute.self::$filename));
        fclose($file);
        return $jsonData; 
    }
    
    public function obj2File($data){
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $url = self::$filerute.self::$filename;
        $file = fopen($url, "w");
        fwrite($file, $json);
       
        $r = fclose($file);
        return $r;
    }
}
?>
