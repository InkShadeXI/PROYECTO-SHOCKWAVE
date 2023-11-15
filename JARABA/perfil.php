<?php require 'cabecera.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img{
            width: 50px;
            height: 50px;
        }
        div{
            /* position: absolute;
            border-top: 30%;
            border-top: 30%; */
            height: 300px;
            width: 300px;
            background-color: grey;
            text-align: center;
            border: 4px solid black;
            border-radius: 10px;
        }
        div>*{
            margin-top: 20px;
        }
    </style>
</head>
<body>

        <?php
           
            $cadena_conexion = "mysql:dbname=empresa;host=127.0.0.1";
            $usuario="root";
            $clave="";
            try{
                $bd=new PDO($cadena_conexion,$usuario,$clave);
            } catch (PDOException){
                echo "Error de acceso a la BBDD";
            }

            // Actualmente no redirecciona a nada los botones
            echo "<div id='foto'><img src=''><br>";
            echo "<b>Nombre: </b>". $_SESSION['usuario']["nombre_usuario"]."<br>";
            echo "<b>Correo: </b>".$_SESSION['usuario']["correo_usuario"]."<br>";
            echo "<form action='BBDD.php'><input type=text  name=camb_cont ><input type='submit' value='Cambiar contraseña' ></form>";
            echo "<form action='BBDD.php'>Nombre nuevo<input type=text  name=camb_nom ><input type='submit' value='Cambiar nombre'></form>";
        ?>
</body>
</html>