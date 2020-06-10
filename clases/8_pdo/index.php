<?php
$pnum = "3";

try {
    $conStr = 'mysql:host=localhost; dbname=utn';
    $user = "root";
    $pass = null;
    $pdo = new PDO($conStr, $user, $pass);
} catch (PDOException $e) {
    exit( 'Error: ' . $e->getMessage() . '<br/>');
}


// ? PDO tiene sentencias preparadas que evitan la inyección de codigo
/*
 * prepare() Signo ? donde va la varialble
 * execute() En el array se pasan las variables que reemplazan los signos ?.
 */
// $query = $pdo->prepare("SELECT * FROM `envios` WHERE pNumero = ?");
// $query->execute(array($pnum));

/* 
 * prepare() :var
 * execute() En el array se pasan las variables ':id'=>$pnum.
 */
// $query = $pdo->prepare("SELECT * FROM `envios` WHERE pNumero = :id");
// $query->execute(array(':id'=>$pnum));

/* 
 * prepare() :var
 * bindParam() var, dato, tipo de dato.  
 * execute() null
 */
$query = $pdo->prepare("SELECT * FROM `envios` WHERE pNumero = :id");
$query->bindParam(':id',$pnum,PDO::PARAM_INT);
$query->execute();

//? cuantas filas fueron afectadas por la consulta
$rowCount = $query->rowCount(); 
echo "rowCount: ".$rowCount."\n";

//? ultimo id insertado en la tabla por la consulta
// $lastId = $pdo->lastInsertId(); 
// echo "lastId: ".$lastId."\n";

$response = $query->fetchAll(PDO::FETCH_ASSOC); //? all
// $response = $query->fetch(PDO::FETCH_ASSOC); //?  one

echo json_encode($response);

