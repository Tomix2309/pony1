<?php if(!defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Controlador AJAX
 *
 * @name    ajax.buscador.php
 * @author  Miguel92
*/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	// NIVELES DE ACCESO Y PLANTILLAS DE CADA ACCIÓN
	$files = array(
		'buscador-buscar'  => array('n' => 0, 'p' => 'buscar'),
		'buscador-usuario' => array('n' => 0, 'p' => 'usuario'),
	);

/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/

	// REDEFINIR VARIABLES
	$tsPage = 'php_files/p.buscador.'.$files[$action]['p'];
	$tsLevel = $files[$action]['n'];
	$tsAjax = empty($files[$action]['p']) ? 1 : 0;

/**********************************\

*	(INSTRUCCIONES DE CODIGO)		*

\*********************************/
	
	// DEPENDE EL NIVEL
	$tsLevelMsg = $tsCore->setLevel($tsLevel, true);
	if($tsLevelMsg != 1) { 
		echo '0: '.$tsLevelMsg; 
		die();
	}
   // CLASE
	include TS_CLASS . 'c.buscador.php';
	$tsBuscador = new tsBuscador();
	// CODIGO
	switch($action){
		case 'buscador-buscar':
			//<---
			$words = $tsCore->setSecure(trim($_POST['word']));
			$resultados = $tsBuscador->SearchAjax($words);
			# Resultados
			$smarty->assign('tsResultados', $resultados['data']);
			# Palabra clave
			$smarty->assign('tsWord', $words);
			# Cantidad de resultados
         $smarty->assign('tsTotal', $resultados['total']);         
			//--->
		break;
		case 'buscador-usuario':
			# Asignamos la función
			$smarty->assign('tsListaU', $tsBuscador->BuscarUsuarios());
		break;
	}
?>