<?php

function comprobar_usuario($nombre, $contraseña){
    $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
    $base = 'root';
    $clave = '';
   // $res = leer_config(dirname(__FILE__)."/configuracion.json", dirname(__FILE__)."/configuracion.json");
    $bd = new PDO($cadena_conexion, $base, $clave);
    $ins = "select nombre_usuario, contrasena_usuario, usuario_admin from usuario where nombre_usuario = '$nombre' and contrasena_usuario = '$contraseña'";
   


    $resul = $bd->query($ins);
    if($resul->rowCount() === 1){		
        return $resul->fetch();		
    }else{
        return FALSE;
    }
}




// <-------------------------------------------------------------------->

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
	
	$usu = comprobar_usuario($_POST['nombre'], $_POST['contraseña']);
    $_SESSION['usuario_admin'] = $usu["usuario_admin"];
	if($usu===false){
		$err = true;
		$usuario = $_POST['nombre'];
	}else{
		if($usu["usuario_admin"] == 1){
            header("Location: zonaadmin.php");
        }else{
            header("Location: home.php");
            
       }
	}	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
  
</style>
<body>
<?php if(isset($_GET["redirigido"])){
			echo "<p>Haga login para continuar</p>";
		}?>
		<?php if(isset($err) and $err == true){
			echo "<p> Revise usuario y contraseña</p>";
		}?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Nombre del Usuario<input type="text" name="nombre" id="nombre"><br>
Contraseña del Usuario<input type="password" name="contraseña" id="contraseña"><br>
<input type="submit" value="Iniciar Sesion">
    </form>
<form action="registro_usuario.php" method="post">
    <input type="submit" value="Registrarse">
</form>
    
</body>
</html>