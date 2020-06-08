<?php
class FileData {

    private static $filerute = './files/';

    public function __construct(){
    }

    public function file2Obj($filename){
        $jsonData = self::file2Json($filename);
        $obj = json_decode($jsonData); 
        return $obj; 
    }
    
    public function file2Json($filename){
        $url = self::$filerute.$filename;
        $file = fopen($url, "r");
        if(filesize(self::$filerute.$filename) > 0){
            $jsonData = fread($file, filesize(self::$filerute.$filename));
        } else {
            $jsonData = null;
        }
        fclose($file);
        return $jsonData; 
    }
    
    public function obj2File($data,$filename){
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $url = self::$filerute.$filename;
        $file = fopen($url, "w");
        fwrite($file, $json);
        $r = fclose($file);
        return $r;
    }
    
}
?>
