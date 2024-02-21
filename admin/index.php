<?php

    //incluye un template
    require '../includes/app.php';
    estaAutenticado();

    use App\Propiedad;
    use App\Vendedor;

    //implementar un metodo para obtener todas las propiedades
    $propiedades = Propiedad::all();
    $vendedores = vendedor::all();



    //muestra un mensaje condicional
    $resultado = $_GET['resultado'] ?? null ;
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            $tipo = $_POST['tipo'];

            if(validarTipoContenido($tipo)){
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if($tipo == 'vendedor'){
                    $vendedor = vendedor::find($id);
                    $vendedor->eliminar();
                }else if($tipo == 'propiedad'){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }

        }
    }


    incluirTemplate('header');

?>

    <main class="contenedor">
        <h1>Administrador de Bienes Raices</h1>

        <?php $mensaje = mostrarMensaje( intval($resultado));
            if($mensaje){ ?>
            <p class="alerta exito"><?php echo s($mensaje); ?></p>
            <?php } ?>

        <a href="/bienesraicesPOO/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>
        <a href="/bienesraicesPOO/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

        <!-- PROPIEDADES  -->
        <h2>Propiedades</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TITULO</th>
                    <th>IMAGEN</th>
                    <th>PRECIO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los resultados -->
                <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="../imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"></td>
                    <td>$ <?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id?>">
            
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/bienesraicesPOO/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- VENDEDORES  -->
        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los Resultados -->
                <?php foreach( $vendedores as $vendedor ): ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td>$ <?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="/bienesraicesPOO/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    </main>
    
<?php
    incluirTemplate('footer');    
?>