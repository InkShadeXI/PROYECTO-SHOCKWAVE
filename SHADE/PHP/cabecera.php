<!-- Enlazar en el resto de php con require -->

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="CSS/cabecera_css.css">
</head>
<header>
    <?php
    session_start();
if(!isset($_SESSION['usuario'])){
  header("Location: login.php?redirigido=true");
    }else if($_SESSION['usuario']['usuario_admin'] == 1){
    echo "
    <ul>
    <li><p class='p_cabecera'>Usuario:  ".$_SESSION['usuario']['nombre_usuario']."</p></li>
    <li><a href=home_shockwave.php>Home</a></li>
    <li><a href=perfil.php>Perfil</a> </li>
    <li><a href=zonaadmin.php>Zona de administrador</a></li>
    <li><input type='text' id='buscador' placeholder='Indica usuario a buscar...'></li<>
    <li><a href=logout.php>Cerrar sesión</a></li>
    </ul>";
        }else if($_SESSION['usuario']['usuario_admin'] == 0){
            echo "
            <ul>
            <li><p class='p_cabecera'>Usuario:  ".$_SESSION['usuario']['nombre_usuario']."</p></li>
            <li><a href=home_shockwave.php>Home</a></li>
            <li><a href=perfil.php>Perfil</a> </li>
            <li><a href=publicar.php>Publicar</a> </li>
            <li><input type='text' id='buscador' placeholder='Indica usuario a buscar...'></li<>
            <li><a href=logout.php>Cerrar sesión</a></li>
            </ul>";
        }
    ?>
 
</header>
<body>

</body>
</html>
