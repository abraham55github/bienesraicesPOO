<?php
    require '../../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as image;

    estaAutenticado();

    // Crear el objeto
    $propiedad = new Propiedad;

    //consulta para obtener todos lo vendedores
    $vendedores = Vendedor::all();

    //arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    //ejutar el codigo despues de que el usuario envia el formulario

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
       
        //crea una nueva instancia
        $propiedad = new Propiedad($_POST['propiedad']);

        /** SUBIDA DE ARCHIVOS **/
        //Generar nombre unico
        $nombreImagen = md5(uniqid(rand(), true)). ".jpg";


        // Setear la imagen
        //realiza un resize a la imagen con intervention
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }


        //validar errores
        $errores = $propiedad->validar();


        //revisar el arreglo de errores
        if(empty($errores)){

            //crear carpeta para subir imagenes
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //guardar imagen
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //guarda en la base de datos
            $propiedad->guardar();

        };

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

        <a href="/bienesraicesPOO/admin/index.php" class="boton boton-verde">Volver</a>

        <form class="formulario" method="POST" action="/bienesraicesPOO/admin/propiedades/crear.php" enctype="multipart/form-data">
            
            <?php include '../../includes/template/formulario_propiedades.php'; ?>

            <input type="submit" value="Crear propiedad" class="boton boton-verde">
        </form>
    </main>
    
<?php
    incluirTemplate('footer');    
?>