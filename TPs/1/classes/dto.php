<?php 
class DTO {
    public static function serialize($data){
        // return $data;
        // return json_encode($data);
        return json_encode($data, JSON_PRETTY_PRINT);
    }
    public static function unserialize($data){
        return json_decode($data);;
    }
}
?>