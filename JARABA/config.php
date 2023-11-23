<?php
function leer_config(){
	$read = file_get_contents("configuracion.json");
	if($read === false) {
		throw new Exception("No se puede cargar la configuración de la BD.");
		return;
	}

	$conf = json_decode($read);
	if($conf === null) {
		throw new Exception("La configuración de la BD tiene un formato desconocido.");
		return;
	}

	if(!property_exists($conf, "ip") || !property_exists($conf, "nombrebd") 
		|| !property_exists($conf, "usuario") || !property_exists($conf, "clave")) {
			throw new Exception("La configuración de la BD no contiene todos los datos requeridos.");
			return;
	}
	$cad = sprintf("mysql:dbname=%s;host=%s", $conf->nombrebd, $conf->ip);
	$resul = [];
	$resul[] = $cad;
	$resul[] = $conf->usuario;
	$resul[] = $conf->clave;
	return $resul;
}