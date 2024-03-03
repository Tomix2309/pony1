<?php

/**
 * Nuevo modelo
 * Syntaxis Lite v3
 * - Mucho más estructurado
 * - Mucho más organizado
 * - Mucho más limpio
 * 
 * @copyright SyntaxisLite v3 - 2024
 * @author Miguel92
*/

if( !defined('SYNTAXISLITEV3') ) define('SYNTAXISLITEV3', TRUE);

// Sesión
if(!isset($_SESSION)) session_start();

// Reporte de errores
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED);
ini_set('display_errors', TRUE);

// Límite de ejecución
set_time_limit(300);

/**
 * -------------------------------------------------------------------
 *  Incluimos todas las definiciones necesarias
 *  en un archivo separado
 * -------------------------------------------------------------------
*/
require_once realpath(__DIR__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'definitions.lite.php';

/*
 * -------------------------------------------------------------------
 *  Agregamos los archivos globales
 * -------------------------------------------------------------------
 */

// Funciones
require_once ROUTEEXTRAS . 'functions.php';

// Nucleo
include ROUTECLASS.'c.core.php';

// Controlador de usuarios
include ROUTECLASS.'c.user.php';

// Monitor de usuario
include ROUTECLASS.'c.monitor.php';

// Actividad de usuario
include ROUTECLASS.'c.actividad.php';

// Mensajes de usuario
include ROUTECLASS.'c.mensajes.php';

# Extraemos, Guardamos en JSON
include ROUTECLASS . "c.jsondb.php";

// Crean requests
include ROUTEEXTRAS.'QueryString.php';
/*
 * -------------------------------------------------------------------
 *  Inicializamos los objetos principales
 * -------------------------------------------------------------------
 */
 
// Limpiar variables...
$cleanRequest->limpiar();

// Cargamos el nucleo
$tsCore = new tsCore();

// Usuario
$tsUser = new tsUser();

// Monitor
$tsMonitor = new tsMonitor();

// Actividad
$tsActividad = new tsActividad();

// Mensajes
$tsMP = new tsMensajes();

# Json
$tsJson = new tsJson();

# NUEVO ARCHIVO DE CONFIGURACION by Miguel92
require_once ROUTEPRIVATE . 'configuration.smarty.php';
require_once ROUTEPRIVATE . 'configuration.additional.php';

/*
 * -------------------------------------------------------------------
 *  Asignaci�n de variables
 * -------------------------------------------------------------------
 */

// Configuraciones
$smarty->assign('tsConfig',$tsCore->settings);

// Obtejo usuario
$smarty->assign('tsUser',$tsUser);

// Avisos
$smarty->assign('tsAvisos', $tsMonitor->avisos);

// Nofiticaciones
$smarty->assign('tsNots',$tsMonitor->notificaciones);

// Mensajes
$smarty->assign('tsMPs',$tsMP->mensajes);

/*
 * -------------------------------------------------------------------
 *  Validaciones extra
 * -------------------------------------------------------------------
 */
// Baneo por IP
$ip = $_SERVER['X_FORWARDED_FOR'] ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
if(!filter_var($ip, FILTER_VALIDATE_IP)) die('Su ip no se pudo validar.'); 
if(db_exec('num_rows', db_exec([__FILE__, __LINE__], 'query', 'SELECT id FROM w_blacklist WHERE type = \'1\' && value = \''.$ip.'\' LIMIT 1'))) die('Bloqueado');

// Online/Offline
if($tsCore->settings['offline'] == 1 && ($tsUser->is_admod != 1 && $tsUser->permisos['govwm'] == false) && $_GET['action'] != 'login-user'){
	$smarty->assign('tsTitle',$tsCore->settings['titulo'].' -  '.$tsCore->settings['slogan']);
	  if(empty($_GET['action'])) 
		$smarty->display('t.mantenimiento.tpl');
	  else die('Espera un poco...');
	exit();
// Banned
} elseif($tsUser->is_banned) {
	  $banned_data = $tsUser->getUserBanned();
	  if(!empty($banned_data)){
			// SI NO ES POR AJAX
			if(empty($_GET['action'])){
				 $smarty->assign('tsBanned',$banned_data);
				 $smarty->display('t.suspension.tpl');
			} 
			else die('<div class="alert alert-warning text-center small font-weight-bolder">Usuario suspendido</div>');
			//
			exit();
	  }
}