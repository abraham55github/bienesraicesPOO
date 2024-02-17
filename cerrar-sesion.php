<?php

session_start();
$_SESSION = [];
header('Location:  bienesraicesPOO/index.php');


var_dump($_SESSION);