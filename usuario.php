<?php

//importar la conexion
require 'includes/config/database.php';
$db = conectarBD();

//crear un email y pasword
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_DEFAULT);


//query para crear al usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHash}');";

/* echo $query; */

//agregarlo a la base de datos
mysqli_query($db, $query);