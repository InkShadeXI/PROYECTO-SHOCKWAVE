<?php
function comprobar_contraseña($contraseña){
    $salt = "patata";
    $saltContraseña = $contraseña.$salt;
    return $saltContraseña; 
}



function comprobar_usuario($nombre, $contraseña){
    $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
    $base = 'root';
    $clave = '';
   // $res = leer_config(dirname(__FILE__)."/configuracion.json", dirname(__FILE__)."/configuracion.json");
    $bd = new PDO($cadena_conexion, $base, $clave);

    $ins = "select nombre_usuario, correo_usuario,contrasena_usuario, usuario_admin from usuario where nombre_usuario = '$nombre'";

    $resul = $bd->query($ins);
    if($resul->rowCount() === 1){
        $user = $resul->fetch();
        $saltContraseña = $user['contrasena_usuario'];
        if (password_verify(comprobar_contraseña($contraseña), $saltContraseña)) {
            return $user;
        }
    }
    return FALSE;
}




// <-------------------------------------------------------------------->

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $contrasena = $_POST['contraseña'];
	
	$usu = comprobar_usuario($_POST['nombre'], $contrasena);
	$_SESSION['usuario'] = $usu;
    if($usu===false){
        $err = true;
		$usuario = $_POST['nombre'];
	}else{
		if($_SESSION['usuario']["usuario_admin"] == true){
            header("Location: zonaadmin.php");
            session_start();
		$_SESSION['usuario'] = $usu;
        }else{
            header("Location: principal.php");
            session_start();
            $_SESSION['usuario'] = $usu;
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
