<?php 
/**
 * @name    files.php
 * @author  Kmario19 - PHPost Team
**/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	$tsPage = "files";	// tsPage.tpl -> PLANTILLA PARA MOSTRAR CON ESTE ARCHIVO.

	$tsLevel = 0;		// NIVEL DE ACCESO A ESTA PAGINA. => VER FAQs

	$tsAjax = empty($_GET['ajax']) ? 0 : 1; // LA RESPUESTA SERA AJAX?
	
	$tsContinue = true;	// CONTINUAR EL SCRIPT
	
/*++++++++ = ++++++++*/

	require_once realpath('../../../') . DIRECTORY_SEPARATOR . "header.php"; // INCLUIR EL HEADER

	$tsTitle = $tsCore->settings['titulo'].' - '.$tsCore->settings['slogan']; 	// TITULO DE LA PAGINA ACTUAL

/*++++++++ = ++++++++*/
   $action = htmlspecialchars($_GET['action']);

	// SI NO ES PRIVADO, LO PUEDEN VER Y DESCARGAR TODOS
	if($action == 'ver' || $action == 'bajar') $tsLevel = 0;
	
	// VERIFICAMOS EL NIVEL DE ACCSESO ANTES CONFIGURADO
	$tsLevelMsg = $tsCore->setLevel($tsLevel, true);
	if($tsLevelMsg != 1){	
		$tsPage = 'aviso';
		$tsAjax = 0;
		$smarty->assign("tsAviso",$tsLevelMsg);
		//
		$tsContinue = false;
	}
	//
	if($tsContinue){
		
/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/

	require_once ROUTECLASS . 'c.files.php';
	$tsFiles = new tsFiles();	

/**********************************\

*	(INSTRUCCIONES DE CODIGO)		*

\*********************************/
	switch($action){
		case '':
			$getFilesUploaded = $tsFiles->getFilesUploaded();
			$smarty->assign('tsArchivos', $getFilesUploaded);
			$smarty->assign('tsCarpetas', $tsFiles->getFolders());
			// Filtros
			$smarty->assign('order', (empty($_GET['o']) ? 'date' : $_GET['o']));
			$smarty->assign('mode', (empty($_GET['m']) ? 'd' : $_GET['m']));
			$smarty->assign('page', (empty($_GET['s']) ? '1' : $_GET['s']));
			$smarty->assign('author', (empty($_GET['a']) ? 'all' : $_GET['a']));

		break;
		case 'subir':
			$tsTitle = "Subir nuevo archivo";
			$smarty->assign('tsCarpetas', $tsFiles->getFolders());
		break;
		case 'descargar':
			$tsFiles->DownloadFile();
			$smarty->assign('tsFileToDownload', $tsFiles->getData($_GET['file']));
		break;
		case 'carpeta':
		case 'encriptado':
			$getFolder = $tsFiles->getFolder();
			$smarty->assign('tsCarpeta', $getFolder);
			//$tsTitle = "Carpeta";
		break;
		case 'ver':
			$getFileUploaded = $tsFiles->getFileUploaded();
			if(is_array($getFileUploaded)) {
				include ROUTEEXTRAS . 'datos.php';
				$smarty->assign('tsArchivo', $getFileUploaded);
				$smarty->assign('tsAutor', $getFileUploaded['author']);
				$smarty->assign('tsDatos', $tsExt);
				//
				$tsTitle = "Archivo {$getFileUploaded['data']['arc_name']}";
				$extension = $getFileUploaded['data']['arc_ext'];
				$smarty->assign('permitidos', in_array($extension, $tsExt['allow']));
				// Escuchar audios
				if($extension == 'mp3') {
					$inf = $tsFiles->getMp3Info($getFileUploaded['data']['url_file'], true);
					$smarty->assign("tsMp3Info", $inf);
				// Ver el contenido de txt, bat, json
				} elseif(in_array($extension, $tsExt['text'])) {
					$smarty->assign("tsInfoFile", $tsFiles->getTxtPhp($getFileUploaded['data']['url_file']));
				// Ver videos
				} elseif(in_array($extension, $tsExt['videos'])) {
					$smarty->assign('mime', $tsExt['mime-video'][$getFileUploaded['data']['arc_ext']]);
					$smarty->assign("tsInfoFile", true);
				}
				// COMENTARIOS
				//$smarty->assign("tsCom", $tsFiles->getComentarios());
			}
		break;
	}

	// HAY ERROR?
	if(!empty($tsError)) {
		$tsPage = 'aviso';
		$smarty->assign("tsAviso",array('titulo' => 'Error', 'mensaje' => $tsError, 'but' => 'Volver', 'link' => "{$tsCore->settings['url']}/files/"));	
	}
		
/**********************************\

* (AGREGAR DATOS GENERADOS | SMARTY) *

\*********************************/
	$up_id = uniqid();
	//
	$smarty->assign("tsAction", $action);   
	$smarty->assign("up_id", $up_id); 
}

if(empty($tsAjax)) {	// SI LA PETICION SE HIZO POR AJAX DETENER EL SCRIPT Y NO MOSTRAR PLANTILLA, SI NO ENTONCES MOSTRARLA.

	$smarty->assign("tsTitle",$tsTitle);	// AGREGAR EL TITULO DE LA PAGINA ACTUAL

	/*++++++++ = ++++++++*/
	include ROUTEGENERAL . "footer.php";
	/*++++++++ = ++++++++*/
}