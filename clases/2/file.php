<?php
$archivo = fopen('file.txt','a+');

// echo fread($archivo,filesize('file.txt')); // lee todo el archivo hasta el limite de bytes

// while(!feof($archivo)){ // itera hasta que termina el archivo
//     echo fgets($archivo); // lee una linea
// }

fwrite($archivo, "nueva linea"); // va a depender de como abrimos el archivo
fwrite($archivo, PHP_EOL); // va a depender de como abrimos el archivo
fput($archivo, "nueva linea"); // googlear

$archivo = fclose($archivo);

copy('file.txt','file2.txt');
unlink('file2.txt'); // borra el archivo

?>