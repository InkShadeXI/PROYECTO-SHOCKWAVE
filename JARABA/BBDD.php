<?php
 session_start();
 echo "<a href=perfil.php>Volver al perfil</a>";
function comprobar_usuario($nombre){
    $cadena_conexion = 'mysql:dbname=redsocial;host=127.0.0.1';
    $base = 'root';
    $clave = '';
   // $res = leer_config(dirname(__FILE__)."/configuracion.json", dirname(__FILE__)."/configuracion.json");
    $bd = new PDO($cadena_conexion, $base, $clave);
    $ins = "select nombre_usuario, contrasena_usuario, correo_usuario, usuario_admin from usuario where nombre_usuario = '$nombre'";

    $resul = $bd->query($ins);
    if($resul->rowCount() === 1){		
        return $resul->fetch();		
    }else{
        return FALSE;
    }
}
use PHPMailer\PHPMailer\PHPMailer;


$_SESSION['USUARIO'];
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
   if(isset($_GET["confirmar"])){
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
      $ins = "INSERT INTO usuario (`NOMBRE_USUARIO`, `CORREO_USUARIO`, `CONTRASENA_USUARIO`, `USUARIO_ADMIN`) VALUES ('$nombre','$correo','".comprobar_contraseña($passwd)."',1)";

      $resul = $bd->query($ins);
    if($resul->rowCount() === 1){		
        return $resul->fetch();		
    }else{
        return FALSE;
    }
    header("Location:login.php");

    }
  }

  if(isset($_GET['camb_nom']) && !empty($_GET['camb_nom'])){
    $camb_nom = $_GET['camb_nom'];
    $nom_ant = $_SESSION['usuario']['nombre_usuario'];
    
    $ins = "UPDATE `usuario` SET `NOMBRE_USUARIO`='$camb_nom' WHERE nombre_usuario = '$nom_ant'";
    $resul = $bd->query($ins);
    header("Location: login.php");
        if($resul->rowCount() === 1){		
            return $resul->fetch();		
        }else{
            return FALSE;
        }

    }
    if(isset($_GET['camb_cont']) && !empty($_GET['camb_cont'])){
        $nuev_cont = $_GET['camb_cont'];
        $correo = $_SESSION['usuario']['correo_usuario'];
        $nombre = $_SESSION['usuario']['nombre_usuario'];
 
         $asunto="Correo de confirmación de cambio de contraseña";
         $cuerpo="Para confirmar el cambio de contraseña <a href=http://localhost/Proyecto/BBDD.php?nombre=$nombre&nuev_cont=$nuev_cont >Haz click en este enlace</a>";          
         $mail ->SetFrom($origen);
         $mail->Subject = "Correo de confirmación de cambio de contraseña";
         $mail->MsgHTML($cuerpo);
         $mail->AddAddress($correo,);
     
        header("Location: login.php");
     
         $resul = $mail->Send();
         if(!$resul) {
         echo "Error" . $mail->ErrorInfo;
         } else {
         echo "Enviado";
         }
 
 
     }

    if(isset($_GET['nuev_cont']) && !empty($_GET['nuev_cont']) && isset($_GET['nombre']) && !empty($_GET['nombre'])){
        $nuev_cont = $_GET['nuev_cont'];
        $nombre = $_GET['nombre'];

        function comprobar_contraseña($nuev_cont){
            $salt = "patata";
            $saltpasswd = $nuev_cont.$salt;
            $hasdedpasswd = password_hash($saltpasswd,PASSWORD_BCRYPT);
            return $hasdedpasswd; 
        }

        $ins = "UPDATE `usuario` SET `CONTRASENA_USUARIO`='".comprobar_contraseña($nuev_cont)."' WHERE nombre_usuario = '$nombre'";
        $resul = $bd->query($ins);
        header("Location: login.php");
            if($resul->rowCount() === 1){		
                return $resul->fetch();		
            }else{
                return FALSE;
            }
    }
}
?>
