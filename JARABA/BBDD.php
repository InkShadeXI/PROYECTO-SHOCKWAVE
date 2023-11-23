<?php
 session_start();
require 'config.php';
 echo "<a href=perfil.php>Volver al perfil</a>";


function comprobar_usuario($nombre){
    
    $res = leer_config(dirname(__FILE__)."/configuracion.json", dirname(__FILE__)."/configuracion.json");
    $bd = new PDO($res[0], $res[1], $res[2]);
    $ins = "select nombre_usuario, contrasena_usuario, correo_usuario, usuario_admin from usuario where nombre_usuario = '$nombre'";

    $resul = $bd->query($ins);
    if($resul->rowCount() === 1){		
        return $resul->fetch();		
    }else{
        return FALSE;
    }
}
use PHPMailer\PHPMailer\PHPMailer;


//$_SESSION['usuario'];
require "vendor/autoload.php";
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug  = 2;                      
$mail->SMTPAuth   = false;
$mail->Host       = "localhost";    
$mail->Port       = 1025;   
$origen = "servidor@destino.com";  

$res = leer_config(dirname(__FILE__)."/configuracion.json", dirname(__FILE__)."/configuracion.json");
	$bd = new PDO($res[0], $res[1], $res[2]);

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
      $ins = "INSERT INTO usuario (`NOMBRE_USUARIO`, `CORREO_USUARIO`, `CONTRASENA_USUARIO`, `USUARIO_ADMIN`) VALUES ('$nombre','$correo','".comprobar_contraseña($passwd)."',0)";

      $resul = $bd->query($ins);
      header("Location:login.php");
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

    $nom_exist = "SELECT nombre_usuario FROM usuario WHERE nombre_usuario = '$camb_nom'";
    $noms = $bd->query($nom_exist);
    if($noms->rowCount() === 1){
        header("Location: perfil.php?usu=".$_SESSION['usuario']['nombre_usuario']."");
    }else{
        $ins = "UPDATE `usuario` SET `NOMBRE_USUARIO`='$camb_nom' WHERE nombre_usuario = '$nom_ant'";
        $resul = $bd->query($ins);
        if ($resul->rowCount() === 1) {
            header("Location: login.php");
        } else {
            echo "No users found";
        }
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


    if(isset($_GET['borrar'])){
        $correo = $_SESSION['usuario']['correo_usuario'];
        $nam = $_SESSION['usuario']["nombre_usuario"];
        $confrim = true;

 
         $asunto="Seguro que quiere borrar la cuenta";
         $cuerpo="Para confirmar el borrar de cuenta <a href=http://localhost/Proyecto/BBDD.php?br=$nam&confrim=true >Haz click en este enlace</a>";          
         $mail ->SetFrom($origen);
         $mail->Subject =  $asunto;
         $mail->MsgHTML($cuerpo);
         $mail->AddAddress($correo,);
     
        header("Location: registro_usuario.php");
     
         $resul = $mail->Send();
         if(!$resul) {
         echo "Error" . $mail->ErrorInfo;
         } else {
         echo "Enviado";
         }
 
 
     }


     if($_GET['confrim'] == true){
      $nam = $_GET['br'];

 $delete= "DELETE FROM usuario WHERE nombre_usuario = '$nam' ";

 $resul = $bd->query($delete);
        if($resul->rowCount() === 1){		
            return $resul->fetch();		
        }else{
            return FALSE;
        }
        header("Location: registro_usuario.php");
     }
     
}
?>

