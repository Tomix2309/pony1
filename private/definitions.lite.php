<?php 

if ( ! defined('SYNTAXISLITEV3')) exit('No direct script access allowed');

//DEFINICION DE CONSTANTES
define('SEPARATOR', DIRECTORY_SEPARATOR);

define('ROUTEGENERAL', 			realpath(dirname(__DIR__)) . SEPARATOR);

define('ROUTEPRIVATE', 			ROUTEGENERAL . 'private' . SEPARATOR);

define('ROUTECACHE', 			ROUTEGENERAL . 'cache' . SEPARATOR);

define('ROUTESMARTY', 			ROUTEPRIVATE . 'smarty' . SEPARATOR);

define('ROUTEFILES', 			ROUTEGENERAL . 'files' . SEPARATOR);

define('ROUTEPLUGINS', 			ROUTEPRIVATE . 'plugins' . SEPARATOR);

define('ROUTEARCHIVOS',			ROUTEFILES . 'archivos' . SEPARATOR);

define('ROUTEAVATAR', 			ROUTEFILES . 'avatar' . SEPARATOR);

define('ROUTEAVATARES', 		ROUTEFILES . 'avatares' . SEPARATOR);

define('ROUTEDESCARGAS', 		ROUTEFILES . 'downloads' . SEPARATOR);

define('ROUTECONFIGURACION', 	ROUTEFILES . 'settings' . SEPARATOR);

define('ROUTEUPLOADS', 			ROUTEFILES . 'uploads' . SEPARATOR);

define('ROUTEINCLUDES', 		ROUTEPRIVATE . 'includes' . SEPARATOR);

define('ROUTECLASS', 			ROUTEINCLUDES . 'class' . SEPARATOR);

define('ROUTEEXTRAS', 			ROUTEINCLUDES . 'ext' . SEPARATOR);

define('ROUTEPHP', 				ROUTEINCLUDES . 'php' . SEPARATOR);

# ACCESS PUBLIC

define('ROUTEPUBLIC', 			ROUTEGENERAL . 'public' . SEPARATOR);

define('ROUTEASSETS', 			ROUTEPUBLIC . 'assets' . SEPARATOR);

define('ROUTEDASHBOARD', 		ROUTEPUBLIC . 'dashboard' . SEPARATOR);

define('ROUTETHEMES', 			ROUTEPUBLIC . 'themes' . SEPARATOR);

define('ROUTEVIEWS', 			ROUTEPUBLIC . 'views' . SEPARATOR);

define('ROUTEDASHPAGES', 		ROUTEDASHBOARD . 'pages' . SEPARATOR);

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('./'));