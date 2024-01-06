<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Controlador AJAX
 *
 * @name    ajax.fotos.php
 * @author  PHPost to-up.net
*/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	// NIVELES DE ACCESO Y PLANTILLAS DE CADA ACCIÓN
	$files = array(		
		'fotos-publicadas' =>  array('n' => 2, 'p' => 'last-fotos'),
	);

/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/

	// REDEFINIR VARIABLES
	$tsPage = 'php_files/p.fotos.'.$files[$action]['p'];
	$tsLevel = $files[$action]['n'];
	$tsAjax = empty($files[$action]['p']) ? 1 : 0;

/**********************************\

*	(INSTRUCCIONES DE CODIGO)		*

\*********************************/
	
	// DEPENDE EL NIVEL
	$tsLevelMsg = $tsCore->setLevel($tsLevel, true);
	if($tsLevelMsg != 1) { echo '0: '.$tsLevelMsg['mensaje']; die();}
    //CLASE
	include("../class/c.fotos.php");
    $tsFotos = new tsFotos();	
	// CODIGO
	switch($action){
		case 'fotos-publicadas':
			$tsLastFotos = $tsFotos->getLastFotos();
			$smarty->assign("tsLastFotos", $tsLastFotos);
			$smarty->assign("tsPages", $tsLastFotos['pages']);
		break;
        default:
            die('0: Este archivo no existe.');
        break;		
	}	