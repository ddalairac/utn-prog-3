<?php
class FileImg {

    private static $filerute = './files/img/';
    
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
        $this->moveOk = move_uploaded_file($tmp_name, self::$filerute . $this->name);

        echo json_encode($this);
    }

}
?>
