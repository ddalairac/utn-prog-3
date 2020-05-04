<?php
use \Firebase\JWT\JWT;
// error_reporting(0);
// ini_set('display_errors', 0);   

class Autenticate {
    public function __construct(){}
    private static $key = "pro3-parcial";
    private static $userFile = 'users.json';

    public function login($user,$pass){
        try {
            $list = FileData::file2Obj(self::$userFile);
            if($list == null){$list = [];}
            foreach ($list as $us) {
                if($user == $us->user && $pass == $us->pass){
                    return self::jwtCreate($user,$us->type);
                }
            }
            return 401;
        } catch (\Throwable $th) {
            return 500;
        }
    }

    public function signin($user,$pass,$type){
        
        try {
            $list = FileData::file2Obj(self::$userFile);
            if($list == null){
                $list = [];
            }
        } catch (\Throwable $th) {
            return 500;
        }

        if(!self::validateUserName($list,$user)){
            return 400;
        }
        
        $newUser = new StdClass();
        $newUser->id = self::setId($list);
        $newUser->user = $user;
        $newUser->pass = $pass;
        $newUser->type = $type;
        array_push($list,$newUser);
        try {
            FileData::obj2File($list,self::$userFile);
        } catch (\Throwable $th) {
            return 500;
        }
        return self::jwtCreate($user,$type);
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
    }

    private function setId($list){
        $max=0;
        foreach($list as $user){
            if($max < $user->id){
                $max = $user->id;
            }
        }
        return $max + 1;
    }
    
    private function validateUserName($list,$user){
        foreach ($list as $us) {
            if($user == $us->user){
                return false;
            }
        }
        return true;
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