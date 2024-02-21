<?php
$database = "mysql:dbname=acme_muyulemaerick;host=127.0.0.1"; // Base de datos y Servidor
$username = "erick"; // Nombre de usuario
$password = "123456"; // Contraseña


try{
    $pdo = new PDO($database, $username, $password);
    //echo "Conectado.";
}catch(PDOException $e){
    echo "Error: ".$e->getMessage();
}

?>
