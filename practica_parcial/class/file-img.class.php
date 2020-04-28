<?php
class FileImg {

    private static $imgRute = './files/img/';
    private static $imgBackupRute = './files/img_backup/';
    
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
        $this->moveOk = move_uploaded_file($tmp_name, self::$imgRute . $this->name);

        // echo json_encode($this);
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

}
?>
