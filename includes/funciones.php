<?php 


define('TEMPLATES_URL', __DIR__ . '/template');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '../../imagenes/');

function incluirTemplate ($nombre, $inicio = false){
    include TEMPLATES_URL . "/{$nombre}.php";
}


function estaAutenticado () {
    session_start();

    if(!$_SESSION['login']){
      header('Location: /bienesraicesPOO/index.php');
    } 
}

function debuguear($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//escapa /sanitizar el html
function s($html){
    $s = htmlspecialchars($html);
    return $s;
}