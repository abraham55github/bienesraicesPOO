<?php
    require '../../includes/funciones.php';
    $auth = estaAutenticado();
    
    if(!$auth){
        header('Location: /bienesraices/index.php');
    }

    require '../../includes/config/database.php';
    $db = conectarBD();

    //consultar para obtener los vendedores

    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);


    //arreglo con mensajes de errores
    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedores_id = '';
    $imagen = '';
    


    //ejutar el codigo despues de que el usuario envia el formulario

    if($_SERVER['REQUEST_METHOD'] === 'POST'){


        /* echo "<pre>";
        var_dump($_POST);
        echo "</pre>"; */

        $titulo = Mysqli_real_escape_string( $db, $_POST['titulo']);
        $precio = Mysqli_real_escape_string( $db, $_POST['precio']);
        $descripcion = Mysqli_real_escape_string( $db, $_POST['descripcion']);
        $habitaciones = Mysqli_real_escape_string( $db, $_POST['habitaciones']);
        $wc = Mysqli_real_escape_string( $db, $_POST['wc']);
        $estacionamiento = Mysqli_real_escape_string( $db, $_POST['estacionamiento']);
        $vendedores_id = Mysqli_real_escape_string( $db, $_POST['vendedores']);
        $creado = date('Y/m/d');
        $imagen = $_FILES['imagen'];


        if(!$titulo){
            $errores[] = "debes añadir un titulo";
        }

        if(!$precio){
            $errores[] = "debes añadir un precio";
        }

        if( strlen($descripcion) < 50){
            $errores[] = "La descripcion es obligatoria y debe tener menos de 50 caracteres";
        }

        if(!$habitaciones){
            $errores[] = "debes añadir una habitacion";
        }

        if(!$wc){
            $errores[] = "debes añadir un baño";
        }

        if(!$estacionamiento){
            $errores[] = "debes añadir un estacionamiento";
        }

        if(!$vendedores_id){
            $errores[] = "debes añadir un vendedor";
        }

        if(!$imagen['name'] || $imagen['error']){
            $errores[] = "la imagen es Obligatorio";
        }

        //Validar por tamaño
        $medida = 1000 *1000;

        if($imagen['size'] > $medida){
            $errores[] = "la imagen es muy pesada";
        }


        //revisar el arreglo de errores
        if(empty($errores)){
            //subida de archivos
            
            //crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
               
            }

            //generar nombre unico

            $nombreImagen = md5(uniqid(rand(), true)). ".jpg";

            //Subir la imagen



            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );

 




            //insertar en la base de datos
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado,  vendedores_id) 
            VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_id')";

            //echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado){
               //redireccionar al usuario
               header('Location: /bienesraices/admin/index.php?resultado=1');
            }
        };



        /*  echo "<pre>";
            var_dump($errores);
            echo "</pre>"; */
        
    }


    incluirTemplate('header');
?>  

    <main class="contenedor">
        <h1>Crear</h1>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>

        <form class="formulario" method="POST" action="/bienesraices/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">
                
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad"value="<?php echo $precio ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen" >

                <label for="descripcion">Descripcion</label>
                <textarea id="Descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>
            <fieldset>
                <legend>Informacion de la propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="Habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento ?>">

            </fieldset>
            <fieldset>
                <legend>Vendedor</legend>
                <select name="vendedores">
                    <option value="">--Seleccione--</option> 
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>">
                        <?php echo $vendedor['nombre']. " " .$vendedor['apellido']; ?>
                        </option> 
                    <?php endwhile; ?>
                </select>
            </fieldset>
            <input type="submit" value="Crear propiedad" class="boton boton-verde">
        </form>
    </main>
    
<?php
    incluirTemplate('footer');    
?>