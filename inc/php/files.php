<?php 
/**
 * @name    files.php
 * @author  Kmario19 - PHPost Team
**/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	$tsPage = "files";	// tsPage.tpl -> PLANTILLA PARA MOSTRAR CON ESTE ARCHIVO.

	$tsLevel = 2;		// NIVEL DE ACCESO A ESTA PAGINA. => VER FAQs

	$tsAjax = empty($_GET['ajax']) ? 0 : 1; // LA RESPUESTA SERA AJAX?
	
	$tsContinue = true;	// CONTINUAR EL SCRIPT
	
/*++++++++ = ++++++++*/

	include "../../header.php"; // INCLUIR EL HEADER

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

	include("../class/c.files.php");
	$tsFiles = new tsFiles();	

/**********************************\

*	(INSTRUCCIONES DE CODIGO)		*

\*********************************/

	switch($action){
		case 'user':
			if(!empty($_GET['userid'])) {
				$userid = $tsUser->getUserID($_GET['userid']);
				$folderid = $_GET['folderid'];
			} else $userid = $tsUser->uid;
			//
			$result = $tsFiles->filesUser($userid);
			if(is_array($result)) {
				$smarty->assign("filesUser", $tsFiles->filesUser($userid, $folderid));
				$smarty->assign("folderUser", $tsFiles->folderUser($folderid, $userid));
				$smarty->assign("getLastcom", $tsFiles->getLastcom());
				$smarty->assign("tsLastFiles", $tsFiles->getLastFiles());
			} else $tsError = $result;
		break;
		case 'ver':
			$tsFile = $tsFiles->verArchivo();
			if(is_array($tsFile)) {
				// NUEVO TITULO
				$tsTitle = 'Descargar '.$tsFile['data']['f_nombre'].'.'.$tsFile['data']['f_ext'].' - '.$tsCore->settings['titulo'];
				if($tsFile['data']['f_ext'] == 'mp3') {
					$inf = $tsFiles->getMp3Info($tsFile['data']['f_url'], true);
					$smarty->assign("tsMp3Info", $inf);
				}
				if($tsFile['data']['f_ext'] == 'txt') {
					// getTxtPhp('archivo', [r, r+, w, w+, a, a+]);
					$inf = $tsFiles->getTxtPhp($tsFile['data']['f_url'], 'r');
					$smarty->assign("tsInfoFile", $inf);
				}
				$smarty->assign("tsFile", $tsFile);
				// COMENTARIOS
				$smarty->assign("tsCom", $tsFiles->getComentarios());
			} else $tsError = $tsFile;
		break;
		case 'bajar':
			$tsFile = $tsFiles->bajarArchivo();
			if(is_array($tsFile)) {
				// FORZAR DESCARGA
				$file = TS_FILES.'archivos/'.$tsFile['f_url'];
				header('Content-Type: application/force-download');
				header("Content-Disposition: attachment; filename=".$tsFile['f_nombre'].".".$tsFile['f_ext']);
			   header('Content-Transfer-Encoding: binary');
			   header('Content-Length: '.filesize($file));
				readfile($file);
			} else $tsError = $tsFile;
		break;
		case 'favoritos':
			$result = $tsFiles->favFiles();
			if(is_array($result)) $smarty->assign("favFiles", $tsFiles->favFiles());
			else $tsError = $result;
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
	$smarty->assign("tsAction",$action);   
	$smarty->assign("up_id", $up_id); 
}

if(empty($tsAjax)) {	// SI LA PETICION SE HIZO POR AJAX DETENER EL SCRIPT Y NO MOSTRAR PLANTILLA, SI NO ENTONCES MOSTRARLA.

	$smarty->assign("tsTitle",$tsTitle);	// AGREGAR EL TITULO DE LA PAGINA ACTUAL

	/*++++++++ = ++++++++*/
	include("../../footer.php");
	/*++++++++ = ++++++++*/
}