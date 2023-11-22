<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    // Agrega la cabecera
    require "cabecera.php";
    echo "<br>";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/home_shockwave.css">
    <!-- Importación de fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // Si la sesión no está actuva, la inicia, de lo contrario lo ignora.
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['usuario'])) {

        $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
        $base = 'root';
        $clave = '';
        
        try {
            $bd = new PDO($cadena_conexion, $base, $clave);

            // El usuario que buscamos
            $seleccion_usuario = $_SESSION['usuario']['nombre_usuario']; 

            // Esta consulta devuelve todos los posts de los amigos del usuario de arriba, los suyos propios y solo los que tienen menos de semana de antiguedad.
            $seleccion_posts = "SELECT * FROM POST_USUARIO WHERE ID_USUARIO_POST IN (
                SELECT DISTINCT ID_USUARIO_1 FROM AMISTAD WHERE ID_USUARIO_2 = (SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = '$seleccion_usuario') 
                UNION
                SELECT ID_USUARIO_2 FROM AMISTAD WHERE ID_USUARIO_1 = (SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = '$seleccion_usuario')
                UNION
                SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = '$seleccion_usuario')
                AND FECHA_CREACION >= DATE_SUB(NOW(), INTERVAL 1 WEEK)"; 
            $seleccion_final = $bd->query($seleccion_posts);
            
            // Esta consulta la usaremos en el foreach para buscar la información de cada usuario de los posts, para mostrar el nombre y otra información.
            $busqueda_usuario = $bd->prepare("SELECT * FROM USUARIO WHERE ID_USUARIO = ?");

            //Esta consulta la usaremos para sacar los comentarios del post en cuestión.
            $busqueda_comentario = $bd->prepare("SELECT * FROM COMENTARIO WHERE ID_COMENTARIO_POST = ?");
        
            // Este será el bucle que vaya mostrando todos los posts según la consulta (la que tiene mucho texto) haya recopilado.
            foreach ($seleccion_final as $resultado) {
                $id_post = $resultado['ID_POST']; // El id del propio post.
                $id_usuario = $resultado['ID_USUARIO_POST']; // El id del usuario del autor del post.
                $busqueda_usuario->execute(array($id_usuario)); // Aquí usamos el id del usuario para recoger la información del usuario que publicó el post y así acceder a su nombre
                $usuario = $busqueda_usuario->fetch(PDO::FETCH_ASSOC); // Le hacemos el fetch para finalizar la consulta.

                $busqueda_comentario->execute(array($id_post)); // Buscamos los comentarios del post.
        
                // Verificar si el usuario existe antes de mostrar los datos:
                echo "<div class='publicacion_usuario'>";
                if (isset($usuario['NOMBRE_USUARIO'])) {
                    echo "<h2 class='titulo_usuario'><a href='perfil.php'>", $usuario['NOMBRE_USUARIO'], "</a> ha publicado:</h2>";
                }
        
                // Verificar si el campo 'texto_post' existe antes de mostrarlo:
                if (isset($resultado['TEXTO_POST'])) {
                    echo "<p class='texto_post'>", $resultado['TEXTO_POST'], "</p>";
                }

                //Verificar si existe una foto para agregarla al post:
                if (isset($resultado['TITULO_FOTO'])) {
                    echo '<img class="foto_post" src="', "USUARIOS/" . $usuario['NOMBRE_USUARIO'] . "/" . $resultado['TITULO_FOTO'], '"/><br>';
                }

                // Verificar si existen comentarios, y si es así guardarlos en una variable.
                $num_comentarios = $busqueda_comentario->rowCount();

                // Aquí generamos la información de likes y disslikes
                echo "<p color='green' class='texto_likes'>" . $resultado['NUM_LIKES'] . "</p>";
                echo "<button id='like_button'><a href='procesar_like.php?action=like&post_id=$id_post'><img class='icons' src='IMG/ICONS/like.png'/></a></button>";
                echo "<p color='red' class='texto_disslikes'>" . $resultado['NUM_DISSLIKES'] . "</p>";
                echo "<button id='like_button'><a href='procesar_like.php?action=disslike&post_id=$id_post'><img class='icons' src='IMG/ICONS/disslike.png'/></a></button>";
                echo "<p color='red' class='texto_comentarios'>" . $num_comentarios . "</p>";
                echo "<button id='like_button'><a href='escribir_mostrar_comentarios.php?id_post=$id_post'><img class='icons' src='IMG/ICONS/comentario.png'/></a></button>";
                echo "</div>";
                echo "<hr>";
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
