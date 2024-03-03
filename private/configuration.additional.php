<?php 

if ( ! defined('SYNTAXISLITEV3')) exit('No direct script access allowed');

/* Establecemos que las paginas no pueden ser cacheadas */
header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("X-Robots-Tag: index, follow", true);

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

$smarty->assign('Lenguaje', $tsCore->settings['idioma']);

$smarty->assign('Lang', str_replace('_', '-', $tsCore->settings['idioma'])); # es-ES

$smarty->assign('Lang_short', substr($tsCore->settings['idioma'], 0, 2)); # es

$smarty->assign('seo', $tsCore->getSettingsSeo());

$smarty->assign('mode', $tsCore->get_mode_user());

$smarty->assign('SL2Site', $tsCore->getSettingsSite());

$smarty->assign('SL2SiteHeader', $tsCore->verify_background('site'));

$Hour = date('G');

$type_day = ($Hour >= 5 && $Hour <= 11) ? 'dias' : (($Hour >= 12 && $Hour <= 18) ? 'tardes' : (($Hour >= 19 || $Hour <= 4) ? 'noches' : ''));
$day = ($type_day == 'dias') ? 'o' : 'a';

$smarty->assign('tsLader', $type_day);
$smarty->assign('tsMessage', "Buen{$day}s<br>$type_day");