<?php


try {
    $conStr = 'mysql:host=localhost; dbname=utn';
    $user = "root";
    $pass = null;
    $pdo = new PDO($conStr, $user, $pass);
    // print_r($pdo);
} catch (PDOException $e) {
    exit( 'Error: ' . $e->getMessage() . '<br/>');
}

$query = $pdo->prepare("SELECT * FROM `envios` WHERE pNumero = 3");
// print_r($query);
$query->execute();
// print_r($query);
$response = $query->fetchAll();
// print_r($response);

echo json_encode($response);


// mixed fetch( [ $fetch_style] )