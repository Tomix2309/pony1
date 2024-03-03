<?php if ( ! defined('SYNTAXISLITEV3')) exit('No se permite el acceso directo al script');
/**
 * Controlador AJAX
 *
 * @name    ajax.generador.php
 * @author  Miguel92
*/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	// NIVELES DE ACCESO Y PLANTILLAS DE CADA ACCIÓN
	$files = array(		
		'generador-normal' =>  array('n' => 2, 'p' => 'normal'),
		'generador-juegos' =>  array('n' => 2, 'p' => 'juegos'),
		'generador-peliculas' =>  array('n' => 2, 'p' => 'peliculas'),
		'generador-acortar' =>  array('n' => 2, 'p' => ''),
	);

/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/

	// REDEFINIR VARIABLES
	$tsPage = 'php_files/generador/p.generador.'.$files[$action]['p'];
	$tsLevel = $files[$action]['n'];
	$tsAjax = empty($files[$action]['p']) ? 1 : 0;

/**********************************\

*	(INSTRUCCIONES DE CODIGO)		*

\*********************************/
	
	// DEPENDE EL NIVEL
	$tsLevelMsg = $tsCore->setLevel($tsLevel, true);
	if($tsLevelMsg != 1) { echo '0: '.$tsLevelMsg['mensaje']; die();}
 
	// CODIGO
	switch($action){
		case 'generador-normal':
		break;
		case 'generador-juegos':
		break;
		case 'generador-peliculas':
		break;
		case 'generador-acortar':
			require_once(ROUTEEXTRAS . 'create_link_short.php');
			echo createAcortador($_POST['url_acortar']);
			//
		break;
      default:
      	die('0: Este archivo no existe.');
      break;		
	}	