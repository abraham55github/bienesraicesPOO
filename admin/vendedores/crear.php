<?php 
    require '../../includes/app.php';
    use App\Vendedor;

    estaAutenticado();

    // Arreglo con mensajes de errores
    $errores = Vendedor::getErrores();
    $vendedor = new Vendedor();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //crear una nueva instanci
        $vendedor = new Vendedor($_POST['vendedor']);

        $errores = $vendedor->validar();

        if(empty($errores)) {
            $vendedor->guardar();
        }


    }

    incluirTemplate('header');

    ?>
    
    <main class="contenedor seccion">
        <h1>Registrar Vendedor</h1>

        

        <a href="/bienesraicesPOO/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/bienesraicesPOO/admin/vendedores/crear.php" enctype="multipart/form-data">
           
            <?php include '../../includes/template/formulario_vendedores.php'; ?>

            <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
        </form>
        
    </main>

<?php 
    incluirTemplate('footer');
?> 

