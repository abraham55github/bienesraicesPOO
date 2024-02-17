<?php 
    //importar la conexion


    $db = conectarBD();
    //consulta
    $query = "SELECT * FROM propiedades LIMIT {$limite}";

    //leer los resultados
    $resultado = mysqli_query($db, $query);

    //iterar

?>


<div class="contenedor-anuncios">

            <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
            <div class="anuncio">

                <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen']?>" alt="anuncio">

                <div class="contenido-anuncio">
                    <h3><?php echo $propiedad['titulo']?></h3>
                    <p><?php echo $propiedad['descripcion']?></p>
                    <p class="precio">$ <?php echo $propiedad['precio']?></p>
                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                            <p><?php echo $propiedad['wc']?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                            <p><?php echo $propiedad['habitaciones']?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p><?php echo $propiedad['estacionamiento']?></p>
                        </li>
                    </ul>
                    <a class="boton boton-amarillo-block" href="anuncio.php?id=<?php echo $propiedad['id']?>">
                        Ver propiedad
                    </a>
                </div> <!-- Contenido-anuncio -->
            </div> <!-- anuncio -->

            <?php endwhile;  ?>

        </div> <!-- contenedor-anuncios -->

<?php 

    //cerrar conexion
    mysqli_close($db);

?>