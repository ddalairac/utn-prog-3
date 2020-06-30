<?php
namespace App\Utils;

use stdClass;
use \Firebase\JWT\JWT; 
use Psr\Http\Message\ServerRequestInterface as Request;

class Autenticate {
    public function __construct(){}
    public static $key = "prog3-parcial2";
    public static $currentUser = [];

    public static function validateReq(Request $request){
        try {
            $jwt = $request->getheaders()["token"][0] ?? '';
            // echo $jwt;
            if(!$jwt){
                throw new RespErrorException("No tiene permisos para realizar esta operacion.", 401);
            }
            // echo "\njwt: "; print_r($jwt);
            $user = Autenticate::jwtDecode($jwt);
            // echo "\nuser: \n"; print_r($user);
                // var_dump($user);
            if (isset($user->email) && isset($user->tipo)) {
                // echo"\n existe email y type\n";
                return $user;
            } else {
                throw new RespErrorException("No tiene permisos para realizar esta operacion.", 401);
            }
        } catch (\Throwable $th) {
            // echo "\nThrowable: \n\n";
            throw new RespErrorException("No tiene permisos para realizar esta operacion.", 401);
        }
    }
    // private static $userFile = 'users.json';

    // public static function login($user,$pass){
    //     try {
    //         $list = FileData::file2Obj(self::$userFile);
    //         if($list == null){$list = [];}
    //         foreach ($list as $us) {
    //             if($user == $us->user && $pass == $us->pass){
    //                 return self::jwtCreate($user,$us->tipo);
    //             }
    //         }
    //         return 401;
    //     } catch (\Throwable $th) {
    //         return 500;
    //     }
    // }

    // public static function signin($user,$pass,$type){
        
    //     try {
    //         $list = FileData::file2Obj(self::$userFile);
    //         if($list == null){
    //             $list = [];
    //         }
    //     } catch (\Throwable $th) {
    //         return 500;
    //     }

    //     if(!self::validateUserName($list,$user)){
    //         return 400;
    //     }
        
    //     $newUser = new StdClass();
    //     $newUser->id = self::setId($list);
    //     $newUser->user = $user;
    //     $newUser->pass = $pass;
    //     $newUser->tipo = $type;
    //     array_push($list,$newUser);
    //     try {
    //         FileData::obj2File($list,self::$userFile);
    //     } catch (\Throwable $th) {
    //         return 500;
    //     }
    //     return self::jwtCreate($user,$type);
    // }

    public static function jwtCreate($user,$type){
        
        $payload = array(
            "iat" => time(),
            "exp" => time() + 1800,
            "sub" => $user,
            "typ" => $type,
        );
        return JWT::encode($payload, self::$key);
    }

    public static function jwtEncode($payload){
        return JWT::encode($payload, self::$key);
    }

    public static function jwtDecode($payload){
        return JWT::decode($payload, self::$key, array('HS256'));
    }

    // private function setId($list){
    //     $max=0;
    //     foreach($list as $user){
    //         if($max < $user->id){
    //             $max = $user->id;
    //         }
    //     }
    //     return $max + 1;
    // }
    
    // private function validateUserName($list,$user){
    //     foreach ($list as $us) {
    //         if($user == $us->user){
    //             return false;
    //         }
    //     }
    //     return true;
    // }
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