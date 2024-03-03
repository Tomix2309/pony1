<?php 



/**
 * Desde este punto vamos a configurar SMARTY
*/
require_once ROUTESMARTY . "bootstrap.php";
$smarty = new Smarty();



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
$addDir['themes'] 	= THEMES;
$addDir['tema'] 		= ROUTETHEMEACTIVE;
$addDir['css'] 		= ROUTETHEMEACTIVE . "css";
$addDir['js'] 			= ROUTETHEMEACTIVE . "js";
$addDir['images'] 	= ROUTETHEMEACTIVE . "images";
$addDir['templates'] = ROUTETEMPLATES;
$addDir['sections'] 	= ROUTESECTIONS;
$addDir['modules'] 	= ROUTEMODULES;
$addDir['comunidades'] 	= ROUTECOMUNIDADES;
//
$addDir['plugins'] 	= ROUTEPLUGINS;
$addDir['public'] 	= TS_PUBLIC;
$addDir['dashboard'] = TS_DASHBOARD;
$addDir['admod'] 		= TS_ADMOD;
$addDir['registro'] 	= TS_VIEWS . "registro" . SEPARATOR;
$addDir['login'] 		= TS_VIEWS . "login" . SEPARATOR;
//
$smarty->setTemplateDir($addDir);

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