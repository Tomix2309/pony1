<?php 

if ( ! defined('SYNTAXISLITEV3')) exit('No direct script access allowed');

// Definimos el template a utilizar
$tsTema = $tsCore->settings['tema']['t_path'];
if(empty($tsTema)) $tsTema = 'default';
define('TS_TEMA', $tsTema);

/**
 * Desde este punto vamos a configurar SMARTY
*/
require_once ROUTESMARTY . "bootstrap.php";
$smarty = new Smarty();

/**
 * DEFINICIONES PARA CUANDO ESTE EN UN THEME
*/
define('ROUTETHEMEACTIVE', 	ROUTETHEMES . TS_TEMA . SEPARATOR);

define('ROUTETEMPLATES', 		ROUTETHEMEACTIVE . "templates" . SEPARATOR);

define('ROUTEMODULES', 			ROUTETEMPLATES . "modules" . SEPARATOR);

// para un rendimiento óptimo
$smarty->setCompileCheck(TRUE);

/**
 * Compilamos los archivos en la carpeta cache
 * @link => https://www.smarty.net/docs/en/api.set.compile.dir.tpl 
*/
$smarty->setCompileDir(ROUTECACHE . TS_TEMA . date('dmy'));


/**
 * Creamos key para asignarle el valor del directorio,
 * ya que estas se usarán en los plugins,
 * ex: "key_name" => valor_carpeta
 * ======================================
 * ATENCIÓN: no deben cambiar el "key_name"
*/
$ADDFOLDERY['admod'] 		= ROUTEDASHPAGES;
$ADDFOLDERY['assets'] 		= ROUTEASSETS;
$ADDFOLDERY['comunidades'] = ROUTETEMPLATES . "comunidades" . SEPARATOR;
$ADDFOLDERY['dashboard'] 	= ROUTEDASHBOARD;
$ADDFOLDERY['modules'] 	 	= ROUTEMODULES;
$ADDFOLDERY['public'] 		= ROUTEPUBLIC;
$ADDFOLDERY['sections'] 	= ROUTETEMPLATES . "sections" . SEPARATOR;
$ADDFOLDERY['tema'] 		 	= ROUTETHEMEACTIVE;
$ADDFOLDERY['templates']  	= ROUTETEMPLATES;
$ADDFOLDERY['themes'] 	 	= ROUTETHEMES;
$ADDFOLDERY['views'] 		= ROUTEVIEWS;
$ADDFOLDERY['plugins'] 		= ROUTEPLUGINS;
//
$smarty->setTemplateDir($ADDFOLDERY);

/**
 * Indicamos la ruta de los plugins para adicionar al sitio,
 * debemos hacer esto para que cuente como parte de smarty
 * @link => https://www.smarty.net/docs/en/api.add.plugins.dir.tpl
*/
$smarty->addPluginsDir(ROUTEPLUGINS);

// SEGURIDAD
$SECURITY_POLICY = new Smarty_Security($smarty);
$SECURITY_POLICY->$php_handling = $smart->PHP_REMOVE;
$SECURITY_POLICY->$allow_php_tag = true;
$SECURITY_POLICY->$modifiers = [];
$SECURITY_POLICY->$php_functions = [];

/**
 * Con esta función habilitamos el acceso a los directorios agregados
 * en la función de $smarty->setTemplateDir(...) si no estan definidos
 * no podran obtener el contenido de las mismas
 * @link => https://www.smarty.net/docs/en/advanced.features.tpl#advanced.features.security
 * @link => https://smarty-php.github.io/smarty/4.x/programmers/advanced-features/advanced-features-security/
*/
if( $tsCore->extras['smarty_security'] ) {
	$smarty->enableSecurity( $SECURITY_POLICY );
}

/**
 * Eliminará: Comentarios, Espacios.
 * Basicamente comprimirá todo el html
 * @link => https://www.smarty.net/docs/en/api.load.filter.tpl
 * @link => https://stackoverflow.com/questions/18673684/minify-html-outputs-in-smarty/28556561
*/
if( $tsCore->extras['smarty_compress'] ) {
	$smarty->loadFilter('output', 'trimwhitespace');
}

$smarty->muteUndefinedOrNullWarnings();