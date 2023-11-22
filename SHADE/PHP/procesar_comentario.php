<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['id_post'])) {
        $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
        $base = 'root';
        $clave = '';

        try {
            $bd = new PDO($cadena_conexion, $base, $clave);

            $id_post = $_SESSION['id_post'];
            $nombre_usuario = $_SESSION['usuario']['nombre_usuario'];

            $id_usuario_seleccion = $bd->prepare('SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = ?');
            $id_usuario_seleccion->execute(array($nombre_usuario));
            $id_usuario = $id_usuario_seleccion->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $id_usuario['ID_USUARIO'];

            $mensaje = $_POST['escribe_comentario'];
            
            $insertar_comentario = $bd->prepare('INSERT INTO COMENTARIO(ID_COMENTARIO_POST, ID_COMENTARIO_USUARIO, TEXTO_COMENTARIO) VALUES(?, ?, ?)');
            $insertar_comentario->execute(array($id_post, $id_usuario, $mensaje));

            header("Location: escribir_mostrar_comentarios.php?id_post=$id_post");
        } 
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }  
    }


?>