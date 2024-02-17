<?php

    require './includes/app.php'; 
    $db = conectarBD();

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password =  mysqli_real_escape_string($db, $_POST['password']);

        if(!$email){
            $errores[] = "El email es obligatorio o no es valido";
        } 

        if(!$password){
            $errores[] = "El password es obligatorio";
        }

        if(empty($errores)){
            $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
            $resultado = mysqli_query($db, $query);
            if($resultado -> num_rows){
                $usuario = mysqli_fetch_assoc($resultado);

                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    session_start();

                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /bienesraicesPOO/admin/index.php');


                }else{
                    $errores[] = 'El password es incorrecto';
                }
            }else {
                $errores[] = "El usuario no existe";
            }
        }


    }


    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado" >
        <h1>Registro de autenticacion</h1>
        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        <form method="POST" class="formulario">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-Mail</label>
                <input type="email" placeholder="Tu email" name="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" placeholder="Tu password" name="password" id="password" required>

            </fieldset>
            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
        </form>

    </main>
    
<?php
    incluirTemplate('footer');    
?>