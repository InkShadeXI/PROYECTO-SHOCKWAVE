<!-- Enlazar en el resto de php con require -->

<!DOCTYPE html>
<html>
<head>
<style>
  html{
    background-image: url(img/fondo.jpg);
    background-size: cover;
  }
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  margin-left: 8px;
  text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #111;
}

p{
    text-align: center;
    color: white;
}

li a:hover:active {
  background-color: #04AA6D;
}
#buscador{
  background-color: gainsboro;
  margin-top: 13px;
  border-radius: 5px;
}
</style>
</head>
<header>
    <?php
    session_start();
if(!isset($_SESSION['usuario'])){
  header("Location: login.php?redirigido=true");
    }else if($_SESSION['usuario']['usuario_admin'] == 1){
    echo "
    <ul>
    <li><p>Usuario:  ".$_SESSION['usuario']['nombre_usuario']."</p></li>
    <li><a href=home_shockwave.php>Home</a></li>
    <li><a href=perfil.php>Perfil</a> </li>
    <li><a href=zonaadmin.php>Zona de administrador</a></li>
    <li><input type='text' id='buscador' placeholder='Indica usuario a buscar...'></li<>
    <li><a href=logout.php>Cerrar sesión</a></li>
    </ul>";
        }else if($_SESSION['usuario']['usuario_admin'] == 0){
            echo "
            <ul>
            <li><p>Usuario:  ".$_SESSION['usuario']['nombre_usuario']."</p></li>
            <li><a href=home_shockwave.php>Home</a></li>
            <li><a href=perfil.php>Perfil</a> </li>
            <li><form action='buscador.php' method='POST'><input type='text' id='buscador' name='buscador' placeholder='Indica usuario a buscar...'></form></li<>
            <li><a href=logout.php>Cerrar sesión</a></li>
            </ul>";
        }
    ?>
 
</header>
<body>

</body>
</html>
