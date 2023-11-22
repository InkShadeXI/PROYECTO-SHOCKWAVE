<?php
function comprobar_usuario($nombre){
    $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
    $base = 'root';
    $clave = '';
   // $res = leer_config(dirname(__FILE__)."/configuracion.json", dirname(__FILE__)."/configuracion.json");
    $bd = new PDO($cadena_conexion, $base, $clave);
    $ins = "select nombre_usuario, contrasena_usuario, usuario_admin from usuario where nombre_usuario = '$nombre'";

    $resul = $bd->query($ins);
    if($resul->rowCount() === 1){		
        return $resul->fetch();		
    }else{
        return FALSE;
    }
}
use PHPMailer\PHPMailer\PHPMailer;
$usu = comprobar_usuario($_POST['nombre'], $_POST['contraseña']);
	$_SESSION['usuario'] = $usu;
require "vendor/autoload.php";
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug  = 2;                      
$mail->SMTPAuth   = false;
$mail->Host       = "localhost";    
$mail->Port       = 1025;   
$origen = "servidor@destino.com";  

$cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
$base = 'root';
$clave = '';
$bd = new PDO($cadena_conexion, $base, $clave);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["nombre"] == $_SESSION['usuario']["nombre_usuario"]){
        header("Location: registro_usuario.php?error=4");

    }else if($_POST["nombre"]!="" && $_POST["correo"]!="" && $_POST["passwd"]!=""){
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $passwd = $_POST["passwd"];

  
    $asunto="Correo de confirmación";
    $cuerpo="Para confirmar el registro <a href=http://localhost/Proyecto/BBDD.php?confirmar=true&nombre=$nombre&correo=$correo&passwd=$passwd >Haz click en este enlace</a>";          
    $mail ->SetFrom($origen);
    $mail->Subject = "Correo de confirmacion";
    $mail->MsgHTML($cuerpo);
    $mail->AddAddress($correo,);

    header("Location: login.php");

    $resul = $mail->Send();
    if(!$resul) {
    echo "Error" . $mail->ErrorInfo;
    } else {
    echo "Enviado";
    }
      

    } else if(($_POST["nombre"])==""){
        header("Location:registro_usuario.php?error=1");
        } else if(($_POST["correo"])==""){
            header("Location:registro_usuario.php?error=2");
            } else if(($_POST["passwd"])==""){
                header("Location:registro_usuario.php?error=3");
                }

}


if($_SERVER["REQUEST_METHOD"] == "GET"){
    $_GET["confirmar"];
    if($_GET["confirmar"] == true){
        
    $nombre =  $_GET["nombre"];
    $correo = $_GET["correo"];
    $passwd =  $_GET["passwd"];
    function comprobar_contraseña($passwd){
        $salt = "patata";
        $saltpasswd = $passwd.$salt;
        $hasdedpasswd = password_hash($saltpasswd,PASSWORD_BCRYPT);
        return $hasdedpasswd; 
    }
      $ins = "INSERT INTO usuario (`NOMBRE_USUARIO`, `CORREO_USUARIO`, `CONTRASENA_USUARIO`, `USUARIO_ADMIN`) VALUES ('$nombre','$correo','".comprobar_contraseña($passwd)."',0)";

      $resul = $bd->query($ins);
      mkdir("usuarios/".$nombre);
    if($resul->rowCount() === 1){		
        return $resul->fetch();		
    }else{
        return FALSE;
    }
    header("Location:login.php");


    }
}
?>
