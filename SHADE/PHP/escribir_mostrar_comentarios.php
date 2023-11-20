<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentar</title>
    <link rel="stylesheet" href="CSS/escribir_mostrar_comentarios.css">
    <!-- Importación de fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Este php será la intefaz para comentar publicaciones. (AUN CON ERRORES)
    require "cabecera.php";
    echo "<br>";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['usuario'])) {

        $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
        $base = 'root';
        $clave = '';
        
        try {
            $bd = new PDO($cadena_conexion, $base, $clave);

            echo "<div id='div_crear_comentario'>";
            echo '<h2 id="titulo_crear_comentario">Comparte tus pensamientos:</h2>';
            echo "<form action='procesar_comentario.php' method='post' enctype='multipart/form-data'>";
            echo "<input type='textarea' name='escribe_comentario' id='escribe_comentario'><br><br>";
            echo "<input type='submit' class='boton_comentario' id='boton_subir_comentario' value='Comentar'><br></form></div>"; 

            $id_post = $_GET['id_post'];
            $seleccion_comentarios = $bd->prepare("SELECT * FROM COMENTARIO WHERE ID_COMENTARIO_POST = ?"); 
            $seleccion_comentarios->execute(array($id_post));

            foreach($seleccion_comentarios as $resultado) {
                $seleccion_usuario = $bd->prepare("SELECT NOMBRE_USUARIO FROM USUARIO WHERE ID_USUARIO = ?");
                $seleccion_usuario->execute(array($reultado["ID_COMENTARIO_USUARIO"]));
                $usuario = $seleccion_usuario->fetch(PDO::FETCH_ASSOC);

                echo "<div class='div_comentario'>";
                echo "<h2 class='titulo_comentario'><a href='perfil.php'>", $usuario['NOMBRE_USUARIO'], "</a> ha comentado:</h2>";
                echo "<p class='texto_comentario'>" . $resultado["TEXTO_COMENTARIO"] . "</p></div><hr>";
            }
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }
    else {
        echo "<h1>Tienes que inicar sesión.</h1>";
    }

    ?>
</body>
</html>