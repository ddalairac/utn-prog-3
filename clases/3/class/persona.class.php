<?php 
class Persona {
    private $file;

    public function __construct(){
        $this->file = new FileData ();
    }

    public function getByID($id){
        $list = $this->getAll();
        foreach ($list as $itm) {
            if($itm->id == $id){
                return $itm;
            }
        }
        return null; 
    }
    public function getAll(){
        return $this->file->file2Obj();
    }
    public function edit($id,$name){
        $list = $this->getAll();
        $editItem = null;
        foreach ($list as $itm) {
            if($itm->id == $id){
                $itm->name = $name;
                $editItem = $itm;
            }
        }
        if(!$editItem){
            return null;
        } else {
            $this->file->obj2File($list);
            return $list;
            // return $editItem;
        }
    }
    
    public function add($name){
        $list = $this->file->file2Obj();
        $max = 1;
        for ($i=0; $i < Count($list); $i++) { 
            if($list[$i]->id > $max){
                $max = $list[$i]->id;
            }
        }
        // asort()
        $newItem = new StdClass();
        $newItem->id = $max + 1;
        $newItem->name = $name;
        array_push($list, $newItem);
        $this->file->obj2File($list);
        return $list;
        // return $newItem;
    }

    public function removeByID($id){
        $list = $this->getAll();
        $removeItem = false;
        foreach ($list as $itm) {
            if($itm->id == $id){
                // Remover
                $removeItem = true;
                $this->file->obj2File($list);
            }
        }
        return $removeItem;
        // if(!$removeItem){
        //     return false;
        // } else {
        //     $this->file->obj2File($list);
        //     return $list;
        //     // return true;
        // }
    }
}

?>