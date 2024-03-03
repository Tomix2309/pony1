<?php 
/**
 * Controlador
 *
 * @name    agregar.php
 * @author  PHPost Team
*/

/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

$tsPage = "agregar";	// tsPage.tpl -> PLANTILLA PARA MOSTRAR CON ESTE ARCHIVO.

$tsLevel = 2;		// NIVEL DE ACCESO A ESTA PAGINA. => VER FAQs

$tsAjax = empty($_GET['ajax']) ? 0 : 1; // LA RESPUESTA SERA AJAX?

$tsContinue = true;	// CONTINUAR EL SCRIPT
	
/*++++++++ = ++++++++*/

require_once realpath('../../../') . DIRECTORY_SEPARATOR . "header.php"; // INCLUIR EL HEADER

$tsTitle = $tsCore->settings['titulo'].' - '.$tsCore->settings['slogan']; 	// TITULO DE LA PAGINA ACTUAL

/*++++++++ = ++++++++*/
	
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


	$action = $_GET['action'];

	if(is_numeric($action)){
		//
		include ROUTECLASS . "c.borradores.php";
		$tsDrafts = new tsDrafts();
		$tsBorrador = $tsDrafts->getDraft();
		$smarty->assign("tsDraft", $tsBorrador);
	// EDITAR POST
	} elseif($action == 'editar'){
		// CLASE
		include ROUTECLASS . "c.posts.php";
		$tsPosts = new tsPosts();
		// GUARDAR
		if(!empty($_POST['titulo'])) {
		  	$post_save = $tsPosts->savePost();
			if($post_save == 1) {
				$tsPost = (int)$_GET['pid'];
				$tsCat = (int)$_POST['categoria'];
				$tsCat = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT c.c_seo FROM p_categorias AS c WHERE c.cid = $tsCat LIMIT 1"));
				$post_url = "{$tsCore->settings['url']}/posts/{$tsCat['c_seo']}/$tsPost/{$tsCore->setSEO($_POST['titulo'])}.html";
				// NOS VAMOS AL POST
				$tsCore->redirectTo($post_url);
			} else {
            $tsPage = 'aviso';
            $smarty->assign("tsAviso", [
            	'titulo' => 'Oops!', 
            	'mensaje' => $post_save, 
            	'but' => 'Volver', 
            	'link' => 'javascript:history.go(-1)'
            ]);
			}
		// EDITAR
		} else {
         $draft = $tsPosts->getEditPost();
         if(!is_array($draft)){
            $tsPage = 'aviso';
            $smarty->assign("tsAviso", [
            	'titulo' => 'Opps...', 
            	'mensaje' => $draft, 
            	'but' => 'Ir a pagina principal', 
            	'link' => $tsCore->settings['url']
            ]);
         } else $smarty->assign("tsDraft", $draft);
		}
		//
		$smarty->assign("tsAction",$_GET['action']);
		$smarty->assign("tsPid",$_GET['pid']);
	// AGREGAR POST	
	} elseif($_POST['titulo']) {
		// CLASE
		include ROUTECLASS . "c.posts.php";
		$tsPosts = new tsPosts();
		//
		$tsPost = $tsPosts->newPost();
		//
		$tsPage = 'aviso';
		$tsAjax = 0;
		if($tsPost > 0) {
			$tsCat = (int)$_POST['categoria'];
			$tsCat = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT c_seo FROM p_categorias WHERE cid = $tsCat LIMIT 1"));
			// Redireccionamos al post que se creo
			$seo = $tsCore->setSEO($_POST['titulo']);
			header("location: {$tsCore->settings['url']}/posts/{$tsCat['c_seo']}/$tsPost/$seo.html");
		// ANTI-FLOOD
		} elseif($tsPost == -1){
			$smarty->assign("tsAviso", [
				'titulo' => 'Anti Flood', 
				'mensaje' => "No puedes realizar tantas acciones en tan poco tiempo. Vuelve a intentarlo en unos instantes.", 
				'but' => 'Volver', 
				'link' => "javascript:history.go(-1)"
			]);
		} else {
			$smarty->assign("tsAviso", [
				'titulo' => 'Oops!', 
				'mensaje' => "Ha ocurrido un error intentalo m&aacute;s tarde.<br><b>Error</b>: ".$tsPost, 
				'but' => 'Volver', 
				'link' => 'javascript:history.go(-1)'
			]);
		}
	}
	
}

if(empty($tsAjax)) {	// SI LA PETICION SE HIZO POR AJAX DETENER EL SCRIPT Y NO MOSTRAR PLANTILLA, SI NO ENTONCES MOSTRARLA.

	$smarty->assign("tsTitle",$tsTitle);	// AGREGAR EL TITULO DE LA PAGINA ACTUAL
	$smarty->assign("tsSubmenu", "agregar");

	/*++++++++ = ++++++++*/
	include ROUTEGENERAL . 'footer.php';
	/*++++++++ = ++++++++*/
}