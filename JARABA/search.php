<?php

function buscarUsuario(){    
 //   $search = $_POST['busqueda'];
    $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
    $base = 'root';
    $clave = '';
    $bd = new PDO($cadena_conexion, $base, $clave);
    $ins = "select nombre_usuario from usuario where nombre_usuario LIKE '%U%'";

    $resul = $bd->query($ins);
    if($resul->rowCount() >= 1){		
        return $resul->fetch();		
    }else{
        return FALSE;
    }

}


try{
$resultBusqueda = buscarUsuario();
$_SESSION["busqueda"] = $resultBusqueda;
if (count($resultBusqueda) > 0) {
    foreach ($_SESSION["busqueda"] as $usuario) {
        if(!empty($usuario)){
         
         
                echo $usuario . "<br>";
            
                    }
    }
} else {
    echo "No users found.";
}

}catch (PDOException $e) {
    echo 'Error con la base de datos: ' . $e->getMessage();
    }

?>
