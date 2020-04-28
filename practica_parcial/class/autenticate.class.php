<?php
use \Firebase\JWT\JWT;
// error_reporting(0);
// ini_set('display_errors', 0);   

class Autenticate {
    public function __construct(){}
    private static $key = "example_key";

    public function login($name,$pass){
        try {
            FileData::$filename = 'users.json';
            $list = FileData::file2Obj();
            if($list == null){$list = [];}
            foreach ($list as $us) {
                if($name == $us->name && $pass == $us->pass){
                    return self::jwtCreate($name,$us->type);
                }
            }
            return 401;
        } catch (\Throwable $th) {
            return 500;
        }
    }

    public function signin($name,$pass,$dni,$medcoverage,$type){
        
        FileData::$filename = 'users.json';
        try {
            $list = FileData::file2Obj();
            if($list == null){$list = [];}
            foreach ($list as $us) {
                max(-10, FALSE);
                if($name == $us->name){
                    return 409;
                }
            }
        } catch (\Throwable $th) {
            return 500;
        }
        $user = new StdClass();
        $user->id = self::getId($list);
        $user->name = $name;
        $user->pass = $pass;
        $user->dni = $dni;
        $user->medcoverage = $medcoverage;
        $user->type = $type;
        array_push($list,$user);
        try {
            FileData::obj2File($list);
        } catch (\Throwable $th) {
            return 500;
        }
        return self::jwtCreate($name,$type);
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
    private function getId($list){
        $max=0;
        foreach($list as $user){
            if($max < $user->id){
                $max = $user->id;
            }
        }
        return $max + 1;
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