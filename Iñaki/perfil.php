<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        img{
            width: 75px;
            height: 75px;
            border: 1px solid white;
            border-radius: 50%;
        }
        div{
            width: 300px;
            height: 400px;
            text-align: center;
            margin: 10% auto;
            display: block;
            border: 3px solid #669900;
            box-shadow: 2px 2px #669900;
            background-color: black;
            padding: 20px;
            color: #669900;
            border-radius: 10px;
        }
        div>*{
            margin-top: 20px;
        }
    </style>
</head>
<body>

        <?php
            require "cabecera.php";
            require "config.php";
             try {
                $res = leer_config(dirname(__FILE__)."/configuracion.json", dirname(__FILE__)."/configuracion.json");
                $bd = new PDO($res[0], $res[1], $res[2]);
                   
                if ($_GET['usu'] == $_SESSION['usuario']["nombre_usuario"]) {
                    echo "<div id='foto'><img src='usuarios/".$_SESSION['usuario']['nombre_usuario']."/logo.jpg'><br>";
                    echo "<b>Nombre: </b>" . $_SESSION['usuario']["nombre_usuario"] . "<br>";
                    echo "<b>Correo: </b>" . $_SESSION['usuario']["correo_usuario"] . "<br>";
                    echo "<form action='BBDD.php'>Contraseña nueva<input type=text  name=camb_cont ><br><br><input type='submit' value='Cambiar contraseña' ></form>";
                    echo "<form action='BBDD.php?confirm=true'>Nombre nuevo<input type=text  name=camb_nom ><br><br><input type='submit' value='Cambiar nombre'></form>";
                    echo "<form action='BBDD.php'><input type='submit' name='borrar' value='Borrar Cuenta' ></form>";
                    echo "<form action='publicar.php'><input type='submit' value='Publicar Post'></form></div>";
        
                } else if (isset($_GET['usu'])) {
                    $user = "SELECT nombre_usuario,correo_usuario,id_usuario FROM usuario WHERE nombre_usuario = :usu";
                    $users = $bd->prepare($user);
                    $users->bindParam(':usu', $_GET['usu']);
                    $users->execute();
                    $_SESSION['Other'] = $users->fetch();
                    $solicitud = "SELECT * FROM amistad WHERE id_usuario_1 = " . $_SESSION['usuario']["id_usuario"] . " AND id_usuario_2 = " . $_SESSION['Other']["id_usuario"];
                    $amistad = $bd->prepare($solicitud);
                    $amistad->execute();
                    $amistadValidada = $amistad->fetch(PDO::FETCH_ASSOC);
        
                    if ($_SESSION['Other']) {
                        echo "<div id='foto'><img src='usuarios/".$_SESSION['Other']["nombre_usuario"]."/logo.jpg'><br>";
                        echo "<b>Nombre: </b>" . $_SESSION['Other']["nombre_usuario"] . "<br>";
                        echo "<b>Correo: </b>" . $_SESSION['Other']["correo_usuario"] . "<br>";
                        if($amistad->rowCount() == 0){
                        echo "<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."?usu=" . $_SESSION['Other']["nombre_usuario"] . " ' method='post'>";
                        echo "<input type='submit' name='amistad' value='Solicitar amistad'></form>";
                        }else if($amistad->rowCount() == 1 && $amistadValidada["Aceptado"]==1){
                            echo "<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."?usu=" . $_SESSION['Other']["nombre_usuario"] . " ' method='post'>";
                            echo "<input type='submit' name='amistad' value='Quitar amistad'></form>";
                        } else if($amistadValidada["Aceptado"]==0){
                            echo "<p>Solicitud pendiente de aprobación</p>";
                        }
                        if($_SERVER["REQUEST_METHOD"] == "POST"){
                            if(isset($_POST['amistad']) && $_POST['amistad']==true && $amistad->rowCount() == 0){
                       $ins_amis = "INSERT INTO amistad (ID_USUARIO_1,ID_USUARIO_2,Aceptado) VALUES (".$_SESSION['usuario']["id_usuario"].",".$_SESSION['Other']["id_usuario"].", 0)";
                       $acept = $bd->prepare($ins_amis);
                       $acept->execute();
                            }else if(isset($_POST['amistad']) && $_POST['amistad'] == true && $amistad->rowCount() == 1){
                            $del_amis = "DELETE FROM amistad WHERE id_usuario_2 = ".$_SESSION['Other']['id_usuario']." AND Aceptado=0";
                            $no_acept = $bd->prepare($del_amis);
                            $no_acept->execute();
                            }
                        echo "</div>";
                    }
                }
            }else{
                header("Location: home_shockwave.php");
            }       
            } catch (PDOException $e) {
                echo "Error de acceso a la BBDD: " . $e->getMessage();
            }
            ?>
</body>
</html>
