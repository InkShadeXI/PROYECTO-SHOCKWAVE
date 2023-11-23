<?php
require_once 'sesiones.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
   $opcion = $_POST["Opciones"];
   $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
   $base = 'root';
   $contraseña = '';
   if (isset($_FILES["archivo"])) {
    $arch = $_FILES["archivo"];
    if (!empty($arch["name"])) {
    try {
        $bd = new PDO($cadena_conexion, $base, $contraseña);
        $string_json = file_get_contents($_FILES["archivo"]["tmp_name"]);
        $objeto_json = json_decode($string_json);
        if($objeto_json === null){
            echo "eL ARCHIVO ESTA MAL FORMULADO";
        }else if($objeto_json != null){
    
    
        if($opcion == "borrar" || $opcion == "crear"){
            $arr = $objeto_json->usuarios;
            for ($i=0; $i < count($arr) ; $i++) {  
            $uss = $arr[$i]; $id = $uss -> ID; $nombre = $uss->nombre; $correo = $uss -> correo; $contraseña = $uss -> contraseña; $rol = $uss -> rol;
    
            if($opcion == "borrar"){
                $ins = "DELETE FROM usuario WHERE id_usuario = $id and nombre_usuario = '$nombre';";
                $insert = $bd->query($ins);
         
               }else if($opcion == "crear"){
                $ins = "INSERT INTO usuario (ID_USUARIO,NOMBRE_USUARIO,CORREO_USUARIO,CONTRASENA_USUARIO,USUARIO_ADMIN) VALUES ($id,'$nombre','$correo','$contraseña',$rol)";
                $insert = $bd->query($ins);
       
               }else{
                echo"Accion no aceptada";
               }
    
            }
        }else if($opcion == "borrar_post"){
            $arr = $objeto_json->posts;
            for ($i=0; $i < count($arr) ; $i++) {  
            $uss = $arr[$i];
            $id_post = $uss -> id_post;
            $id_usuario_post = $uss -> id_usuario_post;
            
                $ins = "DELETE FROM post_usuario WHERE id_post = $id_post and id_usuario_post = $id_usuario_post;";
                $insert = $bd->query($ins);
    
            }
        }else if($opcion == "eliminar_comentario"){
            $arr = $objeto_json->comentarios;
            for ($i=0; $i < count($arr) ; $i++) {  
            $uss = $arr[$i];
            $id_comentario = $uss -> id_comentario;
          
                $ins = "DELETE FROM comentario WHERE id_comentario = $id_comentario;";
                $insert = $bd->query($ins);
             }
          }
        }       
    
    }catch (PDOException $e) {
        echo 'Error con la base de datos: ' . $e->getMessage();
        } 
    }
 }
   if(!empty($_POST['delt_usua']) ){
    
        try{
            $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
            $base = 'root';
            $contraseña = '';
      
            $bd = new PDO($cadena_conexion, $base, $contraseña);
            $ins = "DELETE FROM usuario WHERE nombre_usuario = '".$_POST['delt_usua']."';";
            $insert = $bd->query($ins);
        
    }catch (PDOException $e) {
        echo 'Error con la base de datos: ' . $e->getMessage();
        }
    
 }


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ç, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require 'cabecera.php';?>
    <h1>Zona Admin</h1>
   
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
<input type="file" name="archivo" id="archivo">
<select name="Opciones">
    <option value="borrar" name="borrar" >Borrar Usuarios </option>
    <option value="crear" name="crear" >Crear Usuarios </option>
    <option value="borrar_post" name="borrar_post" >Borrar Post </option>
    <option value="eliminar_comentario" name="eliminar_comentario" >Eliminar comentario </option>
</select>
<input type="submit" value="Subir"><br><br>
<input type="text" name="delt_usua" id="">
<input type="submit" value="Borrar Usuario"><br><br>
<?php require 'search.php';?>
<input type="text" name="busqueda" id="busqueda">
    <input type="submit" value="BUSCAR"><br>
    <?php
if(isset($_POST['busqueda'])){
 if(!empty($_POST['busqueda'])){
    if(!empty($resultBusqueda)){
    foreach ($resultBusqueda as $usuario) {
        echo $usuario['nombre_usuario'] . "<br>"; 
            }
          }else{
            echo "No existen usuarios";
        }
    }  
}
    
?>
</form>
    
</body>
</html>