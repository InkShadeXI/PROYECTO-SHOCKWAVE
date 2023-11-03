<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST["nombre"]!="" && $_POST["correo"]!="" && $_POST["passwd"]!=""){
            $nombre=$_POST["nombre"];
            $correo=$_POST["correo"];
            $passwd=$_POST["passwd"];
            $asunto="Correo de confirmación";
            $cuerpo="Para confirmar el registro <a>Haz click en este enlace</a>";

            mail($correo,$asunto,$cuerpo,$cabecera);    
        } else if(($_POST["nombre"])==""){
            header("Location:registro_usuario.php?error=1");
        } else if(($_POST["correo"])==""){
            header("Location:registro_usuario.php?error=2");
        } else if(($_POST["passwd"])==""){
            header("Location:registro_usuario.php?error=3");
        }
    }
    
?>
