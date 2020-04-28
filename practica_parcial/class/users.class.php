<?php 
class Users {
    public function getUser($sub){
        $list = self::getAll();
        foreach ($list as $user) {
            if($user->mail == $sub){
                return $user;
            }
        }
        return null; 
    }
    public function getUsers(){
        $list = self::getAll();
        $usList = array();
        foreach ($list as $user) {
            if($user->type == "user"){
                $usList[] = $user;
            }
        }
        return $usList; 
    }
    public function getAll(){
        try {
            FileData::$filename = 'users.json';
            return (array)FileData::file2Obj();
        } catch (\Throwable $th) {
            return 500;
        }
    }
    
}

?>