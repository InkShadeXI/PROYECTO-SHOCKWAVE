<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/home_shockwave_css.css">
</head>
<body>
    <?php
    require "cabecera.php";
    if (isset($_SESSION['usuario'])) {
        echo "<a href='usuario.php'>Ir a tu perfil</a>";

        $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
        $base = 'root';
        $clave = '';
        
        try {
            $bd = new PDO($cadena_conexion, $base, $clave);

            // El usuario que buscamos
            $seleccion_usuario = $_SESSION['usuario']['nombre_usuario']; 

            // Esta consulta devuelve todos los posts de los amigos del usuario de arriba.
            $seleccion_posts = "SELECT * FROM POST_USUARIO WHERE ID_USUARIO_POST IN (
                SELECT DISTINCT ID_USUARIO_1 FROM AMISTAD WHERE ID_USUARIO_2 = (SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = '$seleccion_usuario') 
                UNION
                SELECT ID_USUARIO_2 FROM AMISTAD WHERE ID_USUARIO_1 = (SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = '$seleccion_usuario'));"; 
            $seleccion_final = $bd->query($seleccion_posts);
            
            // Esta consulta la usaremos en el foreach para buscar la información de cada usuario de los posts, para mostrar el nombre y otra información.
            $busqueda_usuario = $bd->prepare("SELECT * FROM USUARIO WHERE ID_USUARIO = ?");
        
            // Este será el bucle que vaya mostrando todos los posts según la consulta (la que tiene mucho texto) haya recopilado.
            foreach ($seleccion_final as $resultado) {
                $id_post = $resultado['ID_POST']; // El id del propio post.
                $id_usuario = $resultado['ID_USUARIO_POST']; // El id del usuario del autor del post.
                $busqueda_usuario->execute(array($id_usuario)); // Aquí usamos el id del usuario para recoger la información del usuario que publicó el post y así acceder a su nombre
                $usuario = $busqueda_usuario->fetch(PDO::FETCH_ASSOC); // Le hacemos el fetch para finalizar la consulta.
        
                // Verificar si el usuario existe antes de mostrar los datos:
                if (isset($usuario['NOMBRE_USUARIO'])) {
                    echo "<h2>", $usuario['NOMBRE_USUARIO'], " ha publicado:</h2>";
                }
        
                // Verificar si el campo 'texto_post' existe antes de mostrarlo:
                if (isset($resultado['TEXTO_POST'])) {
                    echo "<p>", $resultado['TEXTO_POST'], "</p>";
                }

                //Verificar si existe una foto para agregarla al post:
                if (isset($resultado['TITULO_FOTO'])) {
                    echo '<img src="', $resultado['TITULO_FOTO'], '"/>';
                }

                // Aquí generamos la información de likes y disslikes
                echo "<p color='green' class='texto_likes'>" . $resultado['NUM_LIKES'] . "</p>";
                echo "<button id='like_button'><a href='procesar_like.php?action=like&post_id=$id_post'>Me gusta</a></button>";
                echo "<p color='red' class='texto_likes'>" . $resultado['NUM_DISSLIKES'] . "</p>";
                echo "<button id='like_button'><a href='procesar_like.php?action=disslike&post_id=$id_post'>No me gusta</a></button>";
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
