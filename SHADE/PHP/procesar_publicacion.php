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
                $id_usuario = $bd->prepare("SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = ?");
                $id_usuario->execute(array($seleccion_usuario));

                // Obtener el resultado de la consulta
                $id_usuario_resultado = $id_usuario->fetch(PDO::FETCH_ASSOC);

                if ($id_usuario_resultado) {
                    $id_usuario = $id_usuario_resultado['ID_USUARIO'];
                } 
                else {
                    echo "Error: Usuario no encontrado.";
                }

                $texto_publicacion = $_POST['texto_publicacion'];
                if (isset($_FILES['foto_publicacion']) && $_FILES['foto_publicacion']['error'] == 0) {
                    $existe_foto = true;
                    $foto = $_FILES['foto_publicacion']['name'];
                
                    // Directorio donde se guardará la foto
                    $nombre_usuario = $_SESSION['usuario']['nombre_usuario'];
                    $directorio_destino = "IMG/USUARIOS/{$nombre_usuario}/";
                
                    // Verificar si el directorio existe, si no, crearlo
                    if (!file_exists($directorio_destino)) {
                        mkdir($directorio_destino, 0777, true);
                    }
                
                    // Ruta completa para guardar la foto en el directorio destino
                    $ruta_destino = $directorio_destino . $foto;
                
                    // Mover la foto al directorio destino
                    move_uploaded_file($_FILES['foto_publicacion']['tmp_name'], $ruta_destino);
                
                } else {
                    $existe_foto = false;
                    $foto = null;
                }
                $cracion_publicacion = $bd->prepare("INSERT INTO POST_USUARIO (ID_USUARIO_POST, TEXTO_POST, EXISTE_FOTO, TITULO_FOTO, NUM_LIKES, NUM_DISSLIKES) 
                VALUES (?, ?, ?, ?, 0, 0)");
                $cracion_publicacion->execute(array($id_usuario, $texto_publicacion, $existe_foto, $foto));
                header("Location: home_shockwave.php");
            } 
            catch (PDOException $e) {
                echo "Error: " . $e->getMessage();                                                 
            }  
        }
    }
}

?>