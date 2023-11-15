<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    if (!isset($_POST["texto_publicacion"])) {
        echo "ERROR: No hay contenido en la publicación.";
    }
    else {
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
                $id_usuario = "SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = $seleccion_usuario";
                $texto_publicacion = $_POST['texto_publicacion'];
                if (isset($_POST['foto_publicacion'])) {
                    $existe_foto = true;
                    $foto = $_POST['foto_publicacion'];
                }
                else {
                    $existe_foto = false;
                    $foto = null;
                }
                $cracion_publicacion = "INSERT INTO POST_USUARIO VALUES ($id_usuario, '$texto_publicacion', $existe_foto, '$foto', 0, 0)";
                

            } 
            catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }  
        }
    }
}

?>