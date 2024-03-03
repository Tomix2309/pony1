<?php if ( ! defined('SYNTAXISLITEV3')) exit('No se permite el acceso directo al script');
/**
 * Controlador AJAX
 *
 * @name    ajax.settings.php
 * @author  PHPost Team
*/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	// NIVELES DE ACCESO Y PLANTILLAS DE CADA ACCI�N
	$files = array(
      'settings-header' => array('n' => 4, 'p' => ''),
      'settings-seo' => array('n' => 4, 'p' => ''),
      'settings-mode' => array('n' => 0, 'p' => ''),
	);

/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/

	// REDEFINIR VARIABLES
	$tsPage = 'php_files/p.settings.'.$files[$action]['p'];
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
		case 'settings-header':
			# Obtiene la lista de archivos .webp en la carpeta
			$where = isset($_POST['type']) ? htmlspecialchars($_POST) : '';
			if(!empty($where)) {
				$carpeta = ($where === 'uploads') ? ROUTEUPLOADS : ROUTEDESCARGAS;
				$archivosWebp = glob($carpeta . '/*.webp');
				// Elimina cada archivo
				foreach ($archivosWebp as $archivo) unlink($archivo);
			}			
			echo $tsCore->save_background('site');
		break;
		case 'settings-seo':
			echo $tsCore->save_configuration_seo();
		break;
		case 'settings-mode':
			echo $tsCore->save_mode();
		break;
      default:
         die('0: Este archivo no existe.');
      break;
	}