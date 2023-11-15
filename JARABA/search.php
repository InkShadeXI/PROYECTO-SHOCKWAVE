<?php
function buscarUsuario() {
    if(isset( $_POST['busqueda'])){
        $search = $_POST['busqueda'];
        if(empty( $_POST['busqueda'])){
        
        } else{
        $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
        $base = 'root';
        $clave = '';
        $bd = new PDO($cadena_conexion, $base, $clave);
    
          
      
            $stmt = $bd->prepare("SELECT nombre_usuario  FROM usuario WHERE nombre_usuario LIKE :search OR correo_usuario = :searchcorr");
            $stmt->bindValue(':search', '%' . $search . '%');
            $stmt->bindValue(':searchcorr', $search);
            $stmt->execute();
    
            if ($stmt->rowCount() >= 1) {
                return $stmt->fetchAll();
            } else {
                return FALSE;
             }
          }
       }
}
try {
    $resultBusqueda = buscarUsuario();

    if ($resultBusqueda == false) {
       
    } else if(count($resultBusqueda) <= 0){
       echo "no existen usuarios";
        }else if(count($resultBusqueda) > 0){
            foreach ($resultBusqueda as $usuario) {
               $busq =   $usuario['nombre_usuario'] . "<br>"; 
             }
       
    }
} catch (PDOException $e) {
    echo 'Error en la base de datos: ' . $e->getMessage();
}
?>
