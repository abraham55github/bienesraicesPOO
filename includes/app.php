<?php 

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//conectarnos a la base de datos

$db = conectarBD();

use App\ActiveRecord;
use Intervention\Image\ImageManagerStatic as image;

ActiveRecord::setDB($db);



