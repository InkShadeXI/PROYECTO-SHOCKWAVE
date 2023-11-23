<?php 
require 'cabecera.php'; 
$cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
$base = 'root';
$clave = '';
$bd = new PDO($cadena_conexion, $base, $clave); 

if(isset($_POST['aceptar']) && $_POST['aceptar']==true){
    $soli_upd = "UPDATE  `amistad` SET Aceptado=1 WHERE Aceptado=0 AND id_usuario_2 = ".$_SESSION['usuario']["id_usuario"]."";
    $soli_acpt = $bd->query($soli_upd);
    
    
    }else if(isset($_POST['rechazar']) && $_POST['rechazar']==true){
        $soli_del = "DELETE FROM `amistad` WHERE Aceptado=0 AND id_usuario_2 = ".$_SESSION['usuario']["id_usuario"]."";
        $soli_borr = $bd->query($soli_del);
        
    }

function Pendientes() {
    $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
    $base = 'root';
    $clave = '';
    $bd = new PDO($cadena_conexion, $base, $clave); 

  $solic_nom = " SELECT usuario.nombre_usuario
FROM usuario
JOIN amistad ON amistad.id_usuario_1 = usuario.id_usuario
WHERE amistad.id_usuario_1 = usuario.id_usuario AND amistad.id_usuario_2 = ".$_SESSION['usuario']["id_usuario"]."
  AND amistad.Aceptado = 0";

$pendi_nom = $bd->query($solic_nom);

 if ($pendi_nom->rowCount() >= 1) {
    return $pendi_nom->fetchAll();
} else {
    return FALSE;
 }

 $solic_nom = " SELECT usuario.nombre_usuario
FROM usuario
JOIN amistad ON amistad.id_usuario_1 = usuario.id_usuario
WHERE amistad.id_usuario_1 = ".$_SESSION['usuario']["id_usuario"]." AND amistad.id_usuario_2 = usuario.id_usuario
  AND amistad.Aceptado = 0";
   if ($pendi_nom->rowCount() >= 1) {
    return $pendi_nom->fetchAll();
} else {
    return FALSE;
 }
}




try {
    $resultBusqueda = Pendientes();

    if ($resultBusqueda == false) {
       
    } else if(count($resultBusqueda) <= 0){
       echo "no existen usuarios";
        }else if(count($resultBusqueda) > 0){
            echo "<div id='contenedor'>";
                   foreach ($resultBusqueda as $solicitudes) {
                      echo  "<div class='perfiles'><p>".$solicitudes['nombre_usuario']."</p></div>"; 
                      echo " <form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method=post>
                      <input type=submit name=aceptar value=Aceptar amistad>";
                      echo " <input type=submit name=rechazar value=Rechazar amistad>
                      </form>";
                    }
                echo "</div>";    
       
    }

} catch (PDOException $e) {
    echo 'Error en la base de datos: ' . $e->getMessage();
}
