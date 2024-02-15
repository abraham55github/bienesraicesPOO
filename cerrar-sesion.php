<?php

session_start();
$_SESSION = [];
header('Location:  bienesraices/index.php');


var_dump($_SESSION);