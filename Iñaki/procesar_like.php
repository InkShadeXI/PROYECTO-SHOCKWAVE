<?php

$cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
$base = 'root';
$clave = '';

try {
    $accion_proceso = $_GET['action'];
    $id_post = $_GET['post_id'];
    $bd = new PDO($cadena_conexion, $base, $clave);
    $seleccion = $bd->prepare("SELECT * FROM POST_USUARIO WHERE ID_POST = ?");
    $seleccion->execute(array($id_post));
    if ($seleccion != null && $id_post != null && $accion_proceso != null) {
        if ($accion_proceso == "like") {
            $like = $bd->prepare("UPDATE POST_USUARIO SET NUM_LIKES = NUM_LIKES + 1 WHERE ID_POST = ?");
            $like->execute(array($id_post));
            echo "Proceso exitoso.";
        }
        else {
            $disslike = $bd->prepare("UPDATE POST_USUARIO SET NUM_DISSLIKES = NUM_DISSLIKES + 1 WHERE ID_POST = ?");
            $disslike->execute(array($id_post));
            echo "Proceso exitoso.";
        }
        header("Location: home_shockwave.php");
    }
    else {
        echo "<p>Ha habido un problema en la sesión.";
    }
} 
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}    

?>
