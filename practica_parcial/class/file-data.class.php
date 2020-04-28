<?php
class FileData {

    private static $filerute = './files/';
    public static $filename = 'users.json';

    public function __construct(){
    }

    public function file2Obj(){
        $jsonData = self::file2Json();
        $obj = json_decode($jsonData); 
        return $obj; 
    }
    
    public function file2Json(){
        $url = self::$filerute.self::$filename;
        $file = fopen($url, "r");
        if(filesize(self::$filerute.self::$filename) > 0){
            $jsonData = fread($file, filesize(self::$filerute.self::$filename));
        } else {
            $jsonData = null;
        }
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
