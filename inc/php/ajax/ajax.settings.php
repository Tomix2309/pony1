<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
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
      'settings-mode' => array('n' => 4, 'p' => ''),
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
				$carpeta = ($where === 'uploads') ? TS_UPLOADS : TS_DOWNLOADS;
				$archivosWebp = glob($carpeta . '/*.webp');
				// Elimina cada archivo
				foreach ($archivosWebp as $archivo) unlink($archivo);
			}			
			echo $tsJson->save_json('background');
		break;
		case 'settings-seo':
			echo $tsJson->save_json('seo');
		break;
		case 'settings-mode':
			echo $tsJson->save_mode();
		break;
      default:
         die('0: Este archivo no existe.');
      break;
	}