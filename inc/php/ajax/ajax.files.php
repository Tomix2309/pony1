<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Controlador AJAX
 *
 * @name    ajax.files.php
 * @author  Kmario19 - PHPost Team
*/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	// NIVELES DE ACCESO Y PLANTILLAS DE CADA ACCIÓN
	$files = array(
		'files-subir' => array('n' => 2, 'p' => ''),
		'files-borrar' =>  array('n' => 2, 'p' => ''),
		'files-admin-borrar' =>  array('n' => 2, 'p' => ''),
		'files-borrar_admin' =>  array('n' => 4, 'p' => ''),
		'files-editar' =>  array('n' => 2, 'p' => ''),
		'files-privado' =>  array('n' => 2, 'p' => ''),
		'files-descargar' =>  array('n' => 0, 'p' => ''),
		'files-favorito' =>  array('n' => 2, 'p' => ''),
		'files-delfav' =>  array('n' => 2, 'p' => ''),
		'files-reactivar' =>  array('n' => 3, 'p' => ''),
		'files-newcom' =>  array('n' => 2, 'p' => 'newcom'),
		'files-delcom' =>  array('n' => 2, 'p' => ''),
		'files-newfolder' =>  array('n' => 2, 'p' => 'folder'),
		'files-editfolder' =>  array('n' => 2, 'p' => ''),
		'files-privfolder' =>  array('n' => 2, 'p' => ''),
		'files-delfolder' =>  array('n' => 2, 'p' => ''),
		'files-verfolders' =>  array('n' => 2, 'p' => ''),
		'files-moverfile' =>  array('n' => 2, 'p' => ''),
		'files-search' =>  array('n' => 2, 'p' => 'search'),
		'files-last-files' =>  array('n' => 2, 'p' => 'last-files'),
		'files-borrar_select' =>  array('n' => 2, 'p' => ''),
		'files-mover_select' =>  array('n' => 2, 'p' => ''),
	);

/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/

	// REDEFINIR VARIABLES
	$tsPage = 'php_files/p.files.'.$files[$action]['p'];
	$tsLevel = $files[$action]['n'];
	$tsAjax = empty($files[$action]['p']) ? 1 : 0;

/**********************************\

*	(INSTRUCCIONES DE CODIGO)		*

\*********************************/
	
	// DEPENDE EL NIVEL
	$tsLevelMsg = $tsCore->setLevel($tsLevel, true);
	if($tsLevelMsg != 1) { echo '0: '.$tsLevelMsg['mensaje']; die();}
	// CLASE
	require('../class/c.files.php');
	$tsFiles = new tsFiles();
	// CODIGO
	switch($action){
		case 'files-subir':
			//<--
			$file = $tsFiles->newFile();
			echo $file;
			//-->
		break;
		case 'files-borrar':
			//<--
			echo $tsFiles->deleteFile();
			//-->
		break;
		case 'files-admin-borrar':
			//<--
			echo $tsFiles->admindeleteFile();
			//-->
		break;
		case 'files-editar':
			//<--
			echo $tsFiles->editFile();
			//-->
		break;
		case 'files-privado':
			//<--
			echo $tsFiles->cambioPrivado();
			//-->
		break;
		case 'files-descargar':
			//<--
			echo $tsFiles->descargaFile();
			//-->
		break;
		case 'files-favorito':
			//<--
			echo $tsFiles->favoritFile();
			//-->
		break;
		case 'files-delfav':
			//<--
			echo $tsFiles->delfavFile();
			//-->
		break;
		case 'files-reactivar':
			//<--
			echo $tsFiles->reactivarFile();
			//-->
		break;
		case 'files-newcom':
			//<--
			$newCom = $tsFiles->newcomFile();
			if(is_array($newCom)) $smarty->assign("newCom",$newCom);
    		else die($newCom);
			//-->
		break;
		case 'files-delcom':
			//<--
			echo $tsFiles->delcomFile();
			//-->
		break;
		case 'files-newfolder':
			//<--
			$folder = $tsFiles->newFolder();
			if(is_array($folder)) $smarty->assign("folder",$folder);
    		else die($folder);
			//-->
		break;
		case 'files-editfolder':
			//<--
			echo $tsFiles->editFolder();
			//-->
		break;
		case 'files-privfolder':
			//<--
			echo $tsFiles->privFolder();
			//-->
		break;
		case 'files-delfolder':
			//<--
			echo $tsFiles->delFolder();
			//-->
		break;
		case 'files-verfolders':
			//<--
			echo $tsCore->setJSON($tsFiles->verFolders());
			//-->
		break;
		case 'files-moverfile':
			//<--
			echo $tsFiles->moverFile();
			//-->
		break;
		case 'files-search':
			//<--
			$smarty->assign("tsResult", $tsFiles->searchFile());
			//-->
		break;
		case 'files-last-files':
			//<--
          $smarty->assign("tsLastFiles", $tsFiles->getLastFiles());
			//-->
		break;
		case 'files-borrar_select':
			//<--
         echo $tsFiles->delFiles();
			//-->
		break;
		case 'files-mover_select':
			//<--
          echo $tsFiles->moverFiles();
			//-->
		break;
	}