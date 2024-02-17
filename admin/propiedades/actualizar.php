<?php
    use App\Propiedad;

    require '../../includes/app.php';
    
    estaAutenticado();

    //validar la url por id validate
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /bienesraicesPOO/admin/index.php');
    }



    //consulta para obtener datos de propiedad
    $propiedad =  Propiedad::find($id);

    // debuguear($propiedad);

    //consultar para obtener los vendedores

    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);


    //arreglo con mensajes de errores
    $errores = [];

    
    //ejutar el codigo despues de que el usuario envia el formulario

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //asignar los atributos

        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        debuguear($propiedad);

        //asignar files hacia una variable
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


        //Validar por tamaño
        $medida = 1000 *1000;
        if($imagen['size'] > $medida){
            $errores[] = "la imagen es muy pesada";
        }


        //revisar el arreglo de errores
        if(empty($errores)){
            /* subida de archivos */

            //crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
               
            }

            $nombreImagen = '';

            
            if($imagen['name']){
                //eliminar archivos
                unlink($carpetaImagenes . $propiedad['imagen']);

                //generar nombre unico
                $nombreImagen = md5(uniqid(rand(), true)). ".jpg";

                //Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );

            } else {
                $nombreImagen = $propiedad['imagen'];
            }
            
            //insertar en la base de datos
            $query = "UPDATE propiedades SET titulo = '{$titulo}' , precio = {$precio}, 
            imagen = '{$nombreImagen}' ,descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, 
            estacionamiento = {$estacionamiento}, vendedores_id = {$vendedores_id} WHERE id = {$id}; ";

            //echo $query;


            $resultado = mysqli_query($db, $query);

            if($resultado){
               //redireccionar al usuario
               header('Location: /bienesraices/admin/index.php?resultado=2');
            }
        };



        /*  echo "<pre>";
            var_dump($errores);
            echo "</pre>"; */
        
    }

    
    incluirTemplate('header');
?>  

    <main class="contenedor">
        <h1>Actualizar Propiedad</h1>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <a href="/bienesraicesPOO/admin/index.php" class="boton boton-verde">Volver</a>

        <form class="formulario" method="POST"  enctype="multipart/form-data">
            
            <?php include '../../includes/template/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>
    
<?php
    incluirTemplate('footer');    
?>