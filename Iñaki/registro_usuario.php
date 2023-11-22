<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        div{
            border: 4px solid black;
            padding: 20px;
            width: 500px;
            border-radius: 20px;
            border: 3px solid #669900;
            box-shadow: 2px 2px #669900;
            background-color: black;
            color: #669900;
            margin: 5% auto;
            display: block;
        }
        .error{
            margin-top: 30px;
            background-color: #CC3333;
            font-weight: bold;
            text-align: center;
        }
        html{
            background-image: url(img/fondo.jpg);
            background-size: cover;
        }
        h1{
            color: #669900;
            text-align: center;
            margin: 2% auto;
            padding: 0;
            text-shadow: 2px 2px 4px #669900;
        }
        #volver{
            float: right;
        }
        .registro{
            width: 100%;
            box-sizing: border-box;

        }
    </style>
</head>
<body>
    <h1>Registro de usuario</h1>
    <?php
        //Registro de usuario
        echo "<div><form action='BBDD.php' method='POST'>
        Indica un nombre de usuario: <input type='text' name='nombre' class='registro'></br></br>
        Indica un email de registro: <input type='text' name='correo' class='registro'></br></br>
        Indica una contraseña: <input type='password' name='passwd' class='registro' ></br></br>
        <input type='submit' value='Registrarse'>
        <a href='login.php'><input type='button' value='Volver al Inicio' id='volver'></a></div>";
        
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
                case 4:
                    echo "<div class='error'>El nombre de usuario ya esta en uso</div>";
                    break;
            }
        }
    ?>
</body>
</html>
