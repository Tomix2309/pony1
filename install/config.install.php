<?php

if(!defined('TS_HEADER')) define('TS_HEADER', true);

define('SEPARATOR', DIRECTORY_SEPARATOR);

define('ROOT', realpath(dirname(__DIR__)) . SEPARATOR);

define('INSTALL', realpath(__DIR__) . SEPARATOR);

define('ARCHIVO_LOCK', ROOT . '.lock');

define('ARCHIVO_HTACCESS', ROOT . '.htaccess');

define('CACHE', ROOT . 'cache' . SEPARATOR);

define('FILES', ROOT . 'files' . SEPARATOR);

define('SMARTY', ROOT . 'inc' . SEPARATOR . 'smarty' . SEPARATOR);

define('AVATAR', FILES . 'avatar' . SEPARATOR);

define('DOWNLOADS', FILES . 'downloads' . SEPARATOR);

define('SETTINGS', FILES . 'settings' . SEPARATOR);

define('UPLOADS', FILES . 'uploads' . SEPARATOR);

# Nombre de la aplicación
$ConfigInstall['nombre'] = 'Syntaxis Lite';
$ConfigInstall['slogan'] = 'Pensar más allá de lo conocido';

# Versión de la aplicación
$ConfigInstall['version'] = '2.0';

$ConfigInstall['version_a'] = "{$ConfigInstall['nombre']} {$ConfigInstall['version']}";

$ConfigInstall['version_b'] = str_replace([' ', '.'], '_', strtolower($ConfigInstall['version_a']));

$ConfigInstall['config'] = [
	'original' => 'config.inc.php',
	'base' => 'config.example.php'
];

define('CONFIG', ROOT . $ConfigInstall['config']['original']);

define('EXAMPLE', INSTALL . $ConfigInstall['config']['base']);

$step = empty($_GET['step']) ? 0 : (int)$_GET['step'];

$next = true;

/**
 * Realizamos verificación de config.inc.php
*/
if(!file_exists(CONFIG)) {
   copy(EXAMPLE, CONFIG);
   chmod(CONFIG, 0666);
}

$ssl = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
   $ssl = 'https';
}
$local = dirname(dirname($_SERVER["REQUEST_URI"]));
// Creando las url base e install
$url = "$ssl://" . ($_SERVER['HTTP_HOST'] === 'localhost' ? "localhost$local" : $_SERVER['HTTP_HOST']);
$base_url = "$url/install";

$withoutspace = str_replace(' ', '', $ConfigInstall['nombre']);
$tpath = "SL2";
$theme = [
	'tid' => 1, 
	't_name' => $ConfigInstall['nombre'] . ' v' . $ConfigInstall['version'], 
	't_url' => '/themes/' . $tpath, 
	't_path' => $tpath, 
	't_copy' => $ConfigInstall['nombre'] . ' 2020 - ' . date('Y')
];

class Install {

	public $carpeta = 0777;

	public $archivo = 0666;

	private $keygen = 'SL2-M1g43l92-';

	public function __construct() {
		// Código ...
	}

	private function forzarPermisos(string $carpeta_archivo = '') {
		$tipo = is_dir($carpeta_archivo) ? $this->carpeta : $this->archivo;
		chmod($carpeta_archivo, $tipo);
	}

	private function existeCarpeta(string $carpeta) {
		if( !is_dir( $carpeta ) ):
			# Creamos la carpeta
			mkdir($carpeta, $this->carpeta, true);
			# Forzamos los permisos
			self::forzarPermisos($carpeta);
		endif;
	}

	public function chequearPermisos(array $chequear = []) {
		foreach ($chequear as $key => $carpeta_archivo) {
			if( is_dir($carpeta_archivo) ):
				self::forzarPermisos($carpeta_archivo);
			else:
				self::existeCarpeta($carpeta_archivo);
			endif;
		}
	}

	private function InfoModules() {
		ob_start();
		phpinfo(INFO_MODULES);
		$phpinfo = ob_get_clean();
		return $phpinfo;
	}

	public function chequearSmarty() {
		/**
		 * Comprobamos que versión de smarty esta instalado
		*/
		if(is_file( SMARTY . "SmartyBC.class.php" )){
			include SMARTY . "SmartyBC.class.php";
			$smarty = new SmartyBC();
			$version = $smarty->_version;
		} else {
			include SMARTY . "Smarty.class.php";
			$smarty = new Smarty();
			$version = $smarty::SMARTY_VERSION;
		}
		
		return $version;
	}

	public function loaderGD(string $type = '') {
		$status = (!extension_loaded('gd') || !function_exists('gd_info'));
		if(!$status) $temp = gd_info();
		$msg['message'] = $status ? "La extensión GD no está habilitada!" : $temp['GD Version'];
		$msg['status'] = !$status;
		return $msg[$type];
	}

	public function loaderCURL(string $type = '') {
		$status = (!extension_loaded('curl'));
		if(!$status) $curlInfo = curl_version();
		$msg['message'] = $status ? "La extensión cURL no está habilitada!" : $curlInfo['version'];
		$msg['status'] = !$status;
		return $msg[$type];
	}

	public function loaderZip(string $type = '') {
		$status = (!extension_loaded('zip'));
		$phpinfo = self::InfoModules();
		if (preg_match("/zip version\s+(.*)/", $phpinfo, $matches)) $zipv = $matches[1];
		$msg['message'] = $status ? "La extensión Zip no está habilitada!" : $zipv;
		$msg['status'] = !$status;
		return $msg[$type];
	}

	public function loaderOpenSSL(string $type = '') {
		$status = (!extension_loaded('openssl'));
		$phpinfo = self::InfoModules();
		// Buscar la línea que contiene "OpenSSL Library Version"
		if (preg_match("/OpenSSL Library Version\s+(.*)/", $phpinfo, $matches)) $opensslVersion = $matches[1];
		$msg['message'] = $status ? "La extensión OpenSSL no está habilitada!" : $opensslVersion;
		$msg['status'] = !$status;
		return $msg[$type];
	}
	public function passwordSL2(string $username = '', string $password = '', string $verify = ''):string {
		$options = ['cost' => 12];
		$createPass = $this->keygen . $username . $password;
		$response = password_hash($createPass, PASSWORD_BCRYPT, $options);
		if(!empty($verify)) $response = password_verify($password, $passHash);
		return $response;
	}

	# Seguridad
	public function modoSeguro($string, $xss = false) {
		global $db, $database;
      // CONECTAMOS
      $database->db = $db;
      $database->db_link = $database->conn();
      $database->setNames();
    	// Verificar si magic_quotes_gpc está activado
    	if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) $string = stripslashes($string);
    	// Escapar el valor
    	$string = $database->escape($string);
    	// Aplicar filtrado XSS si es necesario
    	if ($xss) $string = htmlspecialchars($string, ENT_COMPAT | ENT_QUOTES, 'UTF-8');
    	// Retornamos la información
    	unset($database);
    	unset($db);
    	return $string;
	}
	
	public function is_localhost() {
	   return $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1';
	}

	public function getIUP(array $array = [], string $prefix = ''): string {
	   $sets = [];
	   foreach ($array as $field => $value) $sets[] = "$prefix$field = " . (is_numeric($value) ? (int)$value : "'{$this->modoSeguro($value)}'");
	   return implode(', ', $sets);
	}

}

class DataBase {

	public $db = [];
	public $db_link;

   public function __construct() { 
   }

   public function conn() {
   	try {
   		return new mysqli($this->db['hostname'], $this->db['username'], $this->db['password'], $this->db['database']);
   	} catch (Exception $e) {
			switch ($e->getCode()) {
				case 1045:
					$_SERVER['message'] = "Acceso denegado para el usuario <strong>'{$this->db['username']}'</strong>@'{$this->db['hostname']}'";
				break;
				case 1049:
					$_SERVER['message'] = "La base de datos <strong>{$this->db['database']}</strong> es desconocida o no existe.";
				break;
				case 2002:
					$_SERVER['message'] = "HOST: <strong>{$this->db['hostname']}</strong> desconocido.";
				break;
			}
   	}
   }


	public function error() { 
		return mysqli_error($this->db_link); 
	}

	public function escape($string) { 
		return mysqli_real_escape_string($this->db_link, $string); 
	}

	public function fetch_assoc($query) { 
		return mysqli_fetch_assoc($this->query($query)); 
	}

	public function fetch_row($query) { 
		return mysqli_fetch_row($this->query($query)); 
	}

	public function num_rows($query) { 
		return mysqli_num_rows($this->query($query));
	}

	public function insert_id() {
		return mysqli_insert_id($this->db_link);
	}

   public function query($sql) {
   	return mysqli_query($this->db_link, $sql);
   }

   public function setNames() {
   	return $this->query("SET NAMES 'UTF8'");
   }

}

$Install = new Install;
$database = new DataBase;
$Install->chequearPermisos([CACHE, FILES, UPLOADS, AVATAR, DOWNLOADS, CONFIG, SETTINGS]);

$thumbUp = 'material-symbols:thumb-up';
$thumbDown = 'material-symbols:thumb-down';

// Verificar si la versión es 7.4 o superior
$phpversion = phpversion();
$version_php = (version_compare($phpversion, '7.4', '<')) ? false : true;
$exists['php'] = [
	'nombre'			=> 'PHP 7.x+', 
	'descripcion' 	=> 'Se requiere 7.x+ o superior', 
	'clase' 			=> $version_php ? 'ok' : 'no',
	'version'		=> $phpversion,
	'icon' 			=> $version_php ? $thumbUp : $thumbDown
];
// No es necesario comprobar, porque ya viene la última versión
$exists['smarty'] = [
	'nombre'			=> 'Smarty', 
	'descripcion' 	=> 'Motor de plantillas', 
	'clase' 			=> 'ok',
	'version'		=> $Install->chequearSmarty(),
	'icon' 			=> $thumbUp
];
/**
 * Comprobamos si la biblioteca GD está instalada
*/
$function_exists = (function_exists('gd_info'));
$gdversion = '';
if($function_exists) {
   # LIBRERÍA GD
   $temp = @gd_info();
   $gdversion = $temp['GD Version'];
}
$exists['gd'] = [
	'nombre'			=> 'Biblioteca GD', 
	'descripcion' 	=> 'Biblioteca GD necesaria para recortar imágenes', 
	'clase' 			=> ($function_exists ? 'ok' : 'no'),
	'version'		=> $gdversion,
	'icon' 			=> $function_exists ? $thumbUp : $thumbDown
];
// cURL
$function_exists = (function_exists('curl_init'));
$curlInfo = curl_version();
$exists['curl'] = [
	'nombre'			=> 'cURL', 
	'descripcion' 	=> 'Se utiliza para realizar solicitudes HTTP', 
	'clase' 			=> $function_exists ? 'ok' : 'no',
	'version'		=> $function_exists ? $curlInfo['version'] : '',
	'icon' 			=> $function_exists ? $thumbUp : $thumbDown
];

ob_start();
phpinfo(INFO_MODULES);
$phpinfo = ob_get_clean();
// ZIP
$loaded = (extension_loaded('zip'));
if (preg_match("/zip version\s+(.*)/", $phpinfo, $matches)) $zipv = $matches[1];

$exists['zip'] = [
	'nombre'			=> 'ZIP', 
	'descripcion' 	=> 'La creación y manipulación de archivos ZIP en PHP', 
	'clase' 			=> $loaded ? 'ok' : 'no',
	'version'		=> $loaded ? strip_tags($zipv) : '',
	'icon' 			=> $loaded ? $thumbUp : $thumbDown
];
// OpenSSL
$loaded = (extension_loaded('openssl'));
if (preg_match("/OpenSSL Library Version\s+(.*)/", $phpinfo, $matches)) $opensslVersion = $matches[1];
$exists['openssl'] = [
	'nombre'			=> 'OpenSSL', 
	'descripcion' 	=> 'permite a PHP establecer conexiones seguras mediante el protocolo HTTPS', 
	'clase' 			=> $loaded ? 'ok' : 'no',
	'version'		=> $loaded ? strip_tags($opensslVersion) : '',
	'icon' 			=> $loaded ? $thumbUp : $thumbDown
];