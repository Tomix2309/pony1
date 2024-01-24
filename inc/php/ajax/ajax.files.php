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
		'files-subir' => ['n' => 2, 'p' => ''],
		'files-borrar' =>  ['n' => 2, 'p' => ''],
		'files-admin-borrar' =>  ['n' => 2, 'p' => ''],
		'files-borrar_admin' =>  ['n' => 4, 'p' => ''],
		'files-editar' =>  ['n' => 2, 'p' => ''],
		'files-privado' =>  ['n' => 2, 'p' => ''],
		'files-favorito' =>  ['n' => 2, 'p' => ''],
		'files-delfav' =>  ['n' => 2, 'p' => ''],
		'files-reactivar' =>  ['n' => 3, 'p' => ''],
		'files-newcom' =>  ['n' => 2, 'p' => 'newcom'],
		'files-delcom' =>  ['n' => 2, 'p' => ''],
		// CARPETAS
		'files-crear-carpeta' =>  ['n' => 2, 'p' => 'crear-carpeta'],
		'files-new-folder' =>  ['n' => 2, 'p' => ''],
		'files-editfolder' =>  ['n' => 2, 'p' => ''],
		'files-privfolder' =>  ['n' => 2, 'p' => ''],
		'files-delfolder' =>  ['n' => 2, 'p' => ''],
		'files-verfolders' =>  ['n' => 2, 'p' => ''],
		//
		'files-info' =>  ['n' => 2, 'p' => ''],
		'files-mover-archivo' =>  ['n' => 2, 'p' => ''],
		'files-mover-seleccion' =>  ['n' => 2, 'p' => ''],
		'files-search' =>  ['n' => 2, 'p' => 'search'],
		'files-last-files' =>  ['n' => 2, 'p' => 'last-files'],
		'files-borrar_select' =>  ['n' => 2, 'p' => ''],
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
	require_once TS_CLASS . 'c.files.php';
	$tsFiles = new tsFiles();	
	// CODIGO
	switch($action){
		case 'files-info':
			//<--
			echo $tsFiles->getOnlyInfo();
			//-->
		break;
		case 'files-subir':
			//<--
			echo $tsFiles->fileUpload();
			//-->
		break;
		case 'files-crear-carpeta':
			$smarty->assign("tsTypeOf", $tsFiles->getTypeOfFolders('crear'));
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
		case 'files-favorito':
			//<--
			echo $tsFiles->fileFavourite();
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
		case 'files-new-folder':
			//<--
			echo json_encode($tsFiles->createNewFolder());
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
		case 'files-mover-archivo':
			//<--
			echo (isset($_POST['move']) AND $_POST['move'] == 'true') ? json_encode($tsFiles->getFolders()) : $tsFiles->getFolders();
			//-->
		break;
		case 'files-mover-seleccion':
			//<--
          echo $tsFiles->moveFile();
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
	}