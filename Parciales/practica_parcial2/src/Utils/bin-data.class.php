<?php
namespace App\Utils;

class BinData{

    private static $filerute = __DIR__-'./../storage/bin/';
    
    public function bin2Obj($filename){
        $url = self::$filerute.$filename;
        $file = fopen($url, "r");
        if(filesize(self::$filerute.$filename) > 0){
            $bin = fread($file, filesize(self::$filerute.$filename));
        } else {
            $bin = null;
        }
        fclose($file);
        $obj = unserialize($bin); 
        return $obj;
    } 

    public function Obj2Bin($data,$filename){
        $bin = serialize($data);
        $url = self::$filerute.$filename;
        $file = fopen($url, "w");
        fwrite($file, $bin);
        $r = fclose($file);
        return $r;
    }
}



?>