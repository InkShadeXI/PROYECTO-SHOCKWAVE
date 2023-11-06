<?php

$cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
$base = 'root';
$clave = '';

try {
    $accion_proceso = $_GET['action'];
    $id_post = $_GET['post_id'];
    $bd = new PDO($cadena_conexion, $base, $clave);
    $seleccion = $bd->prepare("SELECT * FROM POST_USUARIO WHERE ID_POST = ?");
    $seleccion->execute(array());
} 
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}    

?>