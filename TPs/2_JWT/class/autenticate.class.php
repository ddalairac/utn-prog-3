<?php
use \Firebase\JWT\JWT;
error_reporting(0);
ini_set('display_errors', 0);   

class Autenticate {
    public function __construct(){}
    private static $key = "example_key";

    public function login($mail,$pass){
        try {
            $list = FileData::file2Obj();
            foreach ($list as $us) {
                if($mail == $us->mail && $pass == $us->pass){
                    return self::jwtCreate($mail,$us->type);
                }
            }
            return 401;
        } catch (\Throwable $th) {
            return 500;
        }
    }

    public function signin($mail,$pass,$name,$lastname,$phone,$type){
        
        try {
            $list = FileData::file2Obj();
            foreach ($list as $us) {
                if($mail == $us->mail){
                    return 409;
                }
            }
        } catch (\Throwable $th) {
            return 500;
        }
        $user = new StdClass();
        $user->mail = $mail;
        $user->pass = $pass;
        $user->name = $name;
        $user->lastname = $lastname;
        $user->phone = $phone;
        $user->type = $type;
        array_push($list,$user);
        try {
            FileData::obj2File($list);
        } catch (\Throwable $th) {
            return 500;
        }
        return self::jwtCreate($mail,$type);
    }

    private function jwtCreate($user,$type){
        
        $payload = array(
            "iat" => time(),
            "exp" => time() + 1800,
            "sub" => $user,
            "typ" => $type,
        );
        return JWT::encode($payload, self::$key);
    }

    public function jwtDecode($jwt){
        return $decoded = JWT::decode($jwt, self::$key, array('HS256'));
        // return (array) $decoded;
    }
}


/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
// JWT::$leeway = 60; // $leeway in seconds
// $decoded = JWT::decode($jwt, $key, array('HS256'));
?>