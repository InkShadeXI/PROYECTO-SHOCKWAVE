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
    session_start();
    if (isset($_SESSION['usuario'])) {
        echo "<a href='usuario.php'>Ir a tu perfil</a>";

        $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
        $base = 'root';
        $clave = '';
        
        try {
            $bd = new PDO($cadena_conexion, $base, $clave);

            $seleccion_amistades = "SELECT * FROM POST_USUARIO WHERE ID_USUARIO_POST IN (
                SELECT DISTINCT ID_USUARIO_1, ID_USUARIO_2 FROM AMISTAD 
                WHERE ID_USUARIO_1 = ( SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = 'USUARIO1' ) OR 
                ID_USUARIO_2 = (
                    SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = ?
                )
            )"; //AQUI VA EL NOMBRE DEL USUARIO DEL CUAL QUEREMOS BUSCAR SUS AMISTADES.

            $seleccion = "SELECT * FROM POST_USUARIO ORDER BY FECHA_CREACION"; //ANTES DEL DESASTRE
            $query = $bd->query($seleccion);
            $busqueda_usuario = $bd->prepare("SELECT NOMBRE_USUARIO FROM USUARIO WHERE ID_USUARIO = ?");
        
            foreach ($query as $resultado) {
                $id_post = $resultado['ID_POST'];
                $id_usuario = $resultado['ID_USUARIO_POST'];
                $busqueda_usuario->execute(array($id_usuario));
                $usuario = $busqueda_usuario->fetch(PDO::FETCH_ASSOC);
        
                // Verificar si el usuario existe antes de mostrar los datos
                if (isset($usuario['NOMBRE_USUARIO'])) {
                    echo "<h2>", $usuario['NOMBRE_USUARIO'], " ha publicado:</h2>";
                }
        
                // Verificar si el campo 'texto_post' existe antes de mostrarlo
                if (isset($resultado['TEXTO_POST'])) {
                    echo "<p>", $resultado['TEXTO_POST'], "</p>";
                }
                if (isset($resultado['TITULO_FOTO'])) {
                    echo '<img src="', $resultado['TITULO_FOTO'], '"/>';
                }
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