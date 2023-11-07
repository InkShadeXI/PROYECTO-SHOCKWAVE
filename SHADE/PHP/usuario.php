<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    session_start();

    if ($_SESSION['usuario'] != null) {
        $usuario_recibido = $_SESSION['usuario']['nombre_usuario'];

        $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
        $usuario = 'root';
        $clave = '';

        $bd = new PDO($cadena_conexion, $usuario, $clave);
        $query = "SELECT id_usuario, nombre_usuario, correo_usuario, usuario_admin FROM usuario WHERE nombre_usuario = '$usuario_recibido'";
        $filas = $bd->query($query);
        foreach ($filas as $fila) {
            echo "<h1>$fila[nombre_usuario]</h1>";
            echo "<h2>$fila[correo_usuario]</h2>";
            if ($fila["usuario_admin"] == 0) {
                echo "<p>No administrador</p>";
            }
            else {
                echo "<p>Administrador</p>";
            }
        }
    }
    ?>
</body>
</html>