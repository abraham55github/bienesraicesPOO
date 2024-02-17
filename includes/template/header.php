<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes raices</title>

    <link rel="stylesheet" href="/bienesraicesPOO/build/css/app.css">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>" >
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/bienesraicesPOO/index.php">
                    <img src="/bienesraicesPOO/build/img/logo.svg" alt="logotico de bienes raices">
                </a>
                <div class="mobile-menu">
                    <img src="/bienesraicesPOO/build/img/barras.svg" alt="icono menu responsive">
                </div>
                <div class="derecha">
                    <img class="dark-mode-boton" src="/bienesraicesPOO/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/bienesraicesPOO/nosotros.php">Nosotros</a>
                        <a href="/bienesraicesPOO/anuncios.php">Anuncios</a>
                        <a href="/bienesraicesPOO/blog.php">Blog</a>
                        <a href="/bienesraicesPOO/contacto.php">Contacto</a>
                        <?php if($auth) : ?> 
                            <a href="cerrar-sesion.php">Cerrar Sesion</a>
                        <?php endif ; ?>
                    </nav>
                </div>
            </div> <!-- barra -->
            <?php if($inicio){ ?> 
                <h1>Venta de casas y departamento Exclusivos de lujos</h1>
            <?php } ?>
            
        </div>
    </header>
