<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear publicación</title>
    <link rel="stylesheet" href="CSS/publicar.css">
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

            // Generamos el documento
            echo "<div id='div_crear_publicacion'>";
            echo "<h2 id='titulo_publicacion'>¿Algo que quieras compartir? :)</h2>";
            echo "<form action='procesar_publicacion.php' method='post'>";
            echo "<input type='textarea' name='texto_publicacion' id='texto_publicacion'><br><br>";
            echo "<input type='file' name='foto_publicacion' class='boton_publicacion' id='boton_subir_foto'>";
            echo "<input type='submit' class='boton_publicacion' id='boton_subir_publicacion' value='Publicar'><br></form></div>";

        } 
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }

    ?>     
</body>
</html>