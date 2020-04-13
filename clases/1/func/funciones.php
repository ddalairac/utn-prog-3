<?php

$nombre = "diego";
$apellido;

echo "Nombre $nombre <br>";
// printf($apellido);
print("nombre $nombre <br>");


echo "strlen: ";
echo strlen($nombre);

echo "<br>";

// foreach(&vec $k => $valor)

$arr = array("foo", "bar", "hello", "world");
var_dump($arr);
echo "<br><br>";
// $arr2 = array("foo"=>2, "bar"=>"a", "hello", "world");
// var_dump($arr2);
// echo "<br><br>";

function saludar($nombre, $apellido = "AA"){ // = da default y se hace opcional
    echo "saludar(): hola $nombre - $apellido<br>";
}

class Persona {
    public $name;
    public function __construct($name){
        $this->name = $name;
    }
    public function saludarP(){
        return "Nombre Persona:". $this->name." <br>";
    }
}

?>