<?php 
/** 
	* NUEVA CONFIGURACIÓN PARA EL SCRIPT Y SMARTY 
	* @author Miguel92 
  * @copyright 2019 - 2024
*/

/* Establecemos que las paginas no pueden ser cacheadas */
header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("X-Robots-Tag: index, follow", true);

/* PARA LAS CLAVES DE RECAPTCHA V3 */
$smarty->assign('tsKeyPbulic', $tsCore->settings['pkey']);

/**
 * -------------------------------------------------------------------
 * DAMOS LA UBICACIÓN GEOGRÁFICA 
 * Página: https://www.php.net/manual/es/timezones.php
 * -------------------------------------------------------------------
*/
date_default_timezone_set((!$tsUser->is_member ? 'America/Argentina/Buenos_Aires' : $tsUser->info["timezone"]));
/**
 * -------------------------------------------------------------------
 * FORZAMOS EL IDIOMA EN ESPAÑOL 
 * Página: https://www.php.net/manual/es/function.setlocale.php
 * -------------------------------------------------------------------
*/
setlocale(LC_ALL, "{$tsCore->settings['idioma']}");
setlocale(LC_TIME, ($tsCore->settings['idioma'] == 'es-ES') ? 'spanish' : 'english');
// windows
putenv("LC_ALL={$tsCore->settings['idioma']}"); 

$smarty->assign([
  'Lenguaje' => $tsCore->settings['idioma'],
  'Lang' => str_replace('_', '-', $tsCore->settings['idioma']), # es-ES
  'Lang_short' => substr($tsCore->settings['idioma'], 0, 2) # es
]);

$Hour = date('G');
if ( $Hour >= 5 && $Hour <= 11 ) {
  $smarty->assign('tsLader', 'dias');
  $smarty->assign('tsMessage', "Buenos<br>días");
} else if ( $Hour >= 12 && $Hour <= 18 ) {
  $smarty->assign('tsLader', 'tardes');
  $smarty->assign('tsMessage', "Buenas<br>tardes");
} else if ( $Hour >= 19 || $Hour <= 4 ) {
  $smarty->assign('tsLader', 'noche');
  $smarty->assign('tsMessage', "Buenas<br>noches");
}

// METADATAS
$seo = $tsJson->getSeo();
$ContentSmarty = [
  "jobSite"   => 'Miguel92 <https://github.com/joelmiguelvalente>',
  "canonical" => urldecode($tsCore->currentUrl()),
  "tsColor"   => $seo['color'],
  "AppFb"     => $seo['app_fb'],
  "TwUser"    => $seo['tw_page']
];
if($_GET['do'] == NULL || $_GET['do'] == 'home' || $tsPage == 'fotos' || $tsPage == 'tops' || $tsPage == 'videos') {
	# SEO
	$ContentSmarty += [
		'tsTitle'           => $tsTitle,
		'tsAuthor'          => 'Miguel92',
		'tsSeoDescripcion'  => $seo['description'],
		'tsPublished'       => $tsCore->timeseo(time()),
		'tsUrl'             => $tsCore->settings['url'],
		'tsImagen'          => $seo['images'],
		'tsImagenSocial'    => $seo['social'],
		'tsKey'             => $seo['keys']
  	];
}

$ContentSmarty += [
	'tsImagenDes'   => $seo['images']['64'],
	'tsFooterDes'   => $seo['descripcion'],
	'tsMobile'      => $detect->isMobile(), # Para detectar que tipo de dispositivo esta usando
	"tsAdmInfo"     => $tsJson->getAdminInfo(),# Extraemos la información del json para modificar
	"tsAdmSeo"      => $tsJson->getSeo(),# Extraemos la información del json para modificar
	"tsStyleAdmin"  => $tsJson->getAddInfo(),# Añadimos la imagen y css al header
	"tsMode"			 => $tsJson->getMode()
];

$smarty->assign($ContentSmarty);