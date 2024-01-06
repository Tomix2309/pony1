<?php

function createAcortador($param_link) {
	# Clave api de OUO
   $ouoapi = 'bNr8mFd4'; 
   # Clave api de fc
   $fcapi = 'df04028639ccb291da42e67e27e93f369c8f81e8';
   # Creamos el alias para fc
   $customalias = 'LinkN' . rand(1, 10000);
	# Obtenemos la petición GET
   $acortado = file_get_contents("http://ouo.io/api/". urlencode($ouoapi) . "?s=". urlencode($param_link));
	// Comprobar si lo que obtuvimo, es un enlace válido utilizando una expresión regular
   if (preg_match('/^(http|https):\/\/ouo\.io\/\w+$/', $acortado) !== 1) throw new Exception("Enlace inesperado al acortar con ouo.io: " . $acortado);
 	# Ahora comenzamos con fc.lc, recibimos el link de ouo.io creado
	$linklargo = urlencode($acortado);
	# Lo guardamos en una variable
	$links = "http://fc.lc/api?api={$fcapi}&url={$linklargo}&alias={$customalias}";
	# Obtenemos la petición GET
	$obtenemos = file_get_contents($links);
	# Decodificamos el JSON
	$result = json_decode($obtenemos,TRUE);
	# Retornaremos la respuesta
	return ($result["status"] === 'error') ? $result["message"] : $result["shortenedUrl"];
}
