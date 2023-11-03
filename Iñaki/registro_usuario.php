<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            margin-left:25%;
        }
        div{
            border: 4px solid black;
            padding: 20px;
            width: 500px;
            border-radius: 20px;
        }
        .error{
            margin-top: 30px;
            background-color: #CC3333;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Registro de usuario</h1>
    <?php
        //Registro de usuario
        echo "<div><form action='BBDD.php' method='POST'>
        Indica un nombre de usuario: <input type='text' name='nombre'></br></br>
        Indica un email de registro: <input type='text' name='correo'></br></br>
        Indica una contraseña: <input type='password' name='passwd'></br></br>
        <input type='submit' value='Registrarse'></div>";
        //Indica error al introducir datos al formulario
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1:
                    echo "<div class='error'>Nombre no introducido</div>";
                    break;
                case 2:
                    echo "<div class='error'>Correo no introducido</div>";
                    break;
                case 3:
                    echo "<div class='error'>Contraseña no introducida</div>";
                    break;
            }
        }
