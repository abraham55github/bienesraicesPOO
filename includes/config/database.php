<?php

function conectarBD() : mysqli {

    $db = new mysqli('localhost', 'root', '1234', 'bienesraices_crud');

    if(!$db){
        echo "Error no se pudo conectar";
        exit;
    }
    return $db;
};