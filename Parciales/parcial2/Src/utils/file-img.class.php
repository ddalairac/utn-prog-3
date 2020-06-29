<?php
namespace App\Utils;

use stdClass;

class FileImg {

    private static $imgRute =  __DIR__-'./../storage/img/';
    private static $imgBackupRute =  __DIR__-'./../storage/img_backup/';
    
    public $moveOk;
    public $name;
    public $type;
    public $size;

    public function __construct($_file){
        $tmp_name = $_file['tmp_name'];
        $nameParts = explode('.',$_file['name']);
        $this->name =  $nameParts[0] . '-' . time() . "." . $nameParts[Count($nameParts) - 1 ];
        $this->type = $_file['type'];
        $this->size = $_file['size'];
        $this->moveOk = move_uploaded_file($tmp_name, self::$imgRute.$this->name);
        // add watermark
        $this->name = $this->addWatermark($this->name);
    }

    public static function removeImg($img){
        if(copy(self::$imgRute . $img->name, self::$imgBackupRute . $img->name)){
            unlink(self::$imgRute . $img->name);
        }
    }
    
    public static function isValidImg($img){
        $response = new StdClass();
        echo "img type".$img['type'];
        if ($img['size'] > 100000) {
            $response->valid = false;
            $response->message = "La imagen es muy grande";
        } else if ($img['type'] != "image/jpeg"){
            $response->valid = false;
            $response->message = "La extension no es correcta";
        } else {
            $response->valid = true;
        }
        return $response;
    }

    public static function addWatermark($fileName){
        $wtrmrk_file = self::$imgRute.'watermark.png';
        $from = self::$imgRute.$fileName;
        $to = $from;

        $watermark = imagecreatefrompng($wtrmrk_file);
        imagealphablending($watermark, false);
        imagesavealpha($watermark, true);
        $img = imagecreatefromjpeg($from);
        $img_w = imagesx($img);
        $img_h = imagesy($img);
        $wtrmrk_w = imagesx($watermark);
        $wtrmrk_h = imagesy($watermark);
        $dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // Centrar W watermark en image
        $dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // Centrar H watermark en image
        imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
        imagejpeg($img, $to, 100);
        imagedestroy($img);
        imagedestroy($watermark);
            
        return $to;
    }
}
