<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // Comprobar si hay búsqueda de usuarios si no mostrar el listado completo
        function buscarUsuario() {
            if(isset( $_POST['buscador'])){
                $search = $_POST['buscador'];
                if(empty( $_POST['buscador'])){
                
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


            // En caso de encontrar que liste usuarios    
           try{
           $resultBusqueda = buscarUsuario($_POST["buscador"]);
           if ($resultBusqueda == false) {
                echo "<div id='vacio'>No hay  usuarios</div>";
           } else if(count($resultBusqueda) <= 0){
              echo "no existen usuarios";
               }else if(count($resultBusqueda) > 0){
                echo "<div id='contenedor'>";
                   foreach ($resultBusqueda as $usuario) {
                      echo  "<div class='perfiles'><a href=perfil.php?usu=".$usuario['nombre_usuario'].">".$usuario['nombre_usuario']."</div>"; 
                    }
                echo "</div>";    
           }
           }catch (PDOException $e) {
               echo 'Error con la base de datos: ' . $e->getMessage();
               }
    ?>
</body>
</html>
