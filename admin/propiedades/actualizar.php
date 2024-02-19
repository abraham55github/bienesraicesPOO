<?php
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as image;

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
    $errores = Propiedad::getErrores();

    
    //ejutar el codigo despues de que el usuario envia el formulario

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //asignar los atributos

        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        //validacion
        $errores = $propiedad->validar();

        //subida de archivos

        //Generar nombre unico
        $nombreImagen = md5(uniqid(rand(), true)). ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }


        //revisar el arreglo de errores
        if(empty($errores)){

           $propiedad->guardar();


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