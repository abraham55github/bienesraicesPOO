<?php
    require './includes/app.php';
    incluirTemplate('header');
?>

    <main class="seccion contenedor">
        <h2>Casas y Depas en venta</h2> 
        <?php 
            include 'includes/template/anuncios.php';
        ?>
    </main>  

<?php
    incluirTemplate('footer');
?>