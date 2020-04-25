<?php
class Response{
    public static $response;
    // public function __constructor($status,$data){
    public function data2DTO($status,$data){
        self::$response = new stdClass();
        self::$response->status = $status;
        if($status == "Error"){
            self::$response->message = $data;
        } else {
            self::$response->data = $data;
        }
        return json_encode(self::$response, JSON_PRETTY_PRINT);
    }
}
?>