<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            color: #669900;
        }
        #vacio{
            width: 200px;
            height: 200px;
            text-align: center;
            margin: 5% auto;
            color: #669900;
            border-radius: 3px;
            border: 3px solid #669900;
            box-shadow: 2px 2px #669900;
            background-color: black;
            font-size: x-large;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            display: block;
        }
        .perfiles{
            width: 100px;
            height: 100px;
            text-align: center;
            margin: 5% 5%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 3px solid #669900;
            box-shadow: 2px 2px #669900;
            background-color: black;
            padding: 20px;
            color: #669900;
            border-radius: 3px;
        }
        #contenedor{
            width: 100%;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
<?php
    require "cabecera.php";
    require "usuario.php";
?>
</body>
</html>
