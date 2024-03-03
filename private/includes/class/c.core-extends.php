<?php 

if ( ! defined('SYNTAXISLITEV3')) exit('No se permite el acceso directo al script');
/**
 * Funciones globales
 *
 * @name    c.core-extends.php
 * @author  PHPost Team
 */

/**
 * 
 */
class tsCoreExtends {

	private $getSite;

	private $page;

	private $style = '';

	private $keygen = 'SL2-M1g43l92-';

	private $route_site = [
		"unsplash" => "https://source.unsplash.com/IMAGEID",
		"pexels" => "https://images.pexels.com/photos/IMAGEID/pexels-photo-IMAGEID.jpeg"
 	];

 	private $position = [
 		'left top',
 		'left center',
      'left bottom',
      'right top',
      'right center',
      'right bottom',
      'center top',
      'center center',
      'center bottom'
   ];

   private $repeat = ['repeat', 'repeat-x', 'repeat-y', 'no-repeat'];

   private $attachment = ['scroll', 'fixed', 'local', 'initial', 'inherit'];
	
	public function __construct() {
		# code...
	}

	# Comprobamos el certificado o protocolo HTTPs | SSL
	public function getProtocol() {
	   $isSecure = false;
	   if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	       $isSecure = true;
	   } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https	' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	       $isSecure = true;
	   }
	   return 'http' . ($isSecure ? 's' : '') . '://';
	}


	/**
	 * Función para obtener el avatar
	*/
	public function getAvatar(int $uid = 0):string {
		$user = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT m.user_id, m.user_avatar, p.p_avatar FROM u_miembros AS m LEFT JOIN u_perfil AS p ON p.user_id = m.user_id WHERE m.user_id = $uid"));
		$ensamble = ((int)$user['p_avatar'] === 1) ? $user['user_id'] : "avatar";
		return "{$this->settings['avatar']}/$ensamble.webp?" . time();
	}
	/**
	 * Función para generar la contraseña
	 * y/o verificar la contraseña del usuario
	 * @param string 
	 * @param string 
	 * @return string
	*/
	public function passwordSL2(string $username = '', string $password = '', string $verify = '') {
		$options = ['cost' => 12];
		$createPass = $this->keygen . $username . $password;
		$response = password_hash($createPass, PASSWORD_BCRYPT, $options);
		if(!empty($verify)) $response = (int)password_verify($createPass, $verify);
		return $response;
	}
	/*
     * Sacar imagen del post
     * si hay mas de una imagen, tomamos la 2 (casi siempre la 1 es de "bienvenido")
   */
	public function extraer_img($texto) {
	   // del tipo [img=imagen] o [img=imagen]
	   preg_match_all('/(\[img(\=|\]))((http|https)?(\:\/\/)?([^\<\>[:space:]]+)\.(jpg|jpeg|png|gif|webp))(\]|\[	\/img\])/i', $texto, $imgs);
	   // Si no se encontraron imágenes, devolver la imagen por defecto
	   if(empty($imgs[3])) {
	      return $this->settings['images'] . '/imagen_no_disponible.webp';
	   }
	   // Devolver la primera imagen encontrada
	   return $imgs[3][0];
	}


   public function nobbcode($nobbcode = '') {
    	// Elimina los códigos BBcodes
    	$nobbcode = preg_replace('/\[([^\]]*)\]/', '', $nobbcode); 
    	// Elimina las URLs
    	$nobbcode = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', ' ', $nobbcode);
    	return $nobbcode;
	}


	public function truncate($string = '', $can = NULL){
		$stc = ($can == '') ? '150' : $can;
		$str = wordwrap($string, $stc);
		$str = str_replace('&nbsp;', ' ', $str);
		$str = explode("\n", $str);
		$str = $str[0] . '...';
		return $str;
	}

	public function timeseo($time = '') {
		return date('Y-m-d\TH:i:s\Z', $time);
	}

	public function getSettingsSeo() {
		$query = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT seo_titulo, seo_descripcion, seo_portada, seo_favicon, seo_imagenes, seo_robots, seo_robots_name, seo_robots_content, seo_color, seo_app_fb, seo_tw_page, seo_keywords FROM w_seo WHERE wid = 1"));
		$query['seo_imagenes'] = unserialize($query['seo_imagenes']);
		return $query;
	}

	public function getSettingsSite() {
		$query = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT setting_mode, setting_attachment, setting_position, setting_repeat, setting_size, setting_type, setting_id, setting_width, setting_height FROM w_settings WHERE wid = 1"));
		return $query;
	}

	public function get_mode_user() {
		$tsUser = new tsUser;
		if($tsUser->is_member) {
			$uid = (int)$tsUser->uid;
			$query = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT setting_mode FROM u_settings WHERE user_id = $uid"));
			return $query['setting_mode'];
		} return 'light';
	}

	private function postSecure(bool $serialize = false, string $clave = '') {
		$tsCore = new tsCore;
		foreach($_POST as $post_key => $valores) {
			if($post_key == 'pid') continue;
			if(is_array($valores)) {
				foreach($valores as $valor_key => $valor) {
					$clave = empty($clave) ? $valor_key : $clave;
					if($serialize) $valor_array[$clave] = $tsCore->setSecure($valor);
					else $valor_array = $tsCore->setSecure($valor_key);
				}
				$data[$post_key] = ($serialize) ? serialize($valor_array) : $valor_array;
			} else {
				$data[$post_key] = is_numeric($valores) ? (int)$valores : $tsCore->setSecure($valores);
			}
		}
		return $data;
	}

	public function save_configuration_seo() {
		$tsCore = new tsCore;
		$data = self::postSecure(true);
      // Guardamos
      if (db_exec([__FILE__, __LINE__], 'query', "UPDATE w_seo SET {$tsCore->getIUP($data)} WHERE wid = 1")) return true;
      else exit( show_error('Error al ejecutar la consulta de la l&iacute;nea '.__LINE__.' de '.__FILE__.'.', 'db') );
	}

	public function save_mode() {
		$tsCore = new tsCore;
		//
		$uid = (int)$_POST['uid'];
		$mode = $tsCore->setSecure($_POST['mode']);
		// Verificamos que exista registro
		$existe = verify_data([__FILE__, __LINE__], "user_id", "u_settings", "user_id = $uid");
		if($existe == 0) {
			if(db_exec([__FILE__, __LINE__], 'query', "INSERT INTO u_settings (user_id, setting_mode) VALUES($uid, '$mode')")) {
				return '1: La configuarción se guardo correctamente';
			} return '0: No se pudo aplicar la configuarción.';
		} else {
			if(db_exec([__FILE__, __LINE__], 'query', "UPDATE u_settings SET user_id = $uid, setting_mode = '$mode' WHERE user_id = $uid")) {
				return '1: La configuarción se guardo correctamente';
			} return '0: No se pudo guardar la configuarción.';
		} return '0: Hubo un error, intente nuevamente.';
	}

	/**
	 * Generar portada tanto para el sitio como para el usuario
	*/
	private function BuildUrl(string $page = '') {
		$width = (int)$_POST['setting_width'];
		$height = (int)$_POST['setting_height'];
		// URL DE LA IMAGEN
		$url = str_replace('IMAGEID', $_POST['setting_id'], $this->route_site[$page]);
		// AÑADIMOS PARAMETROS
		if($page == 'pexels') {
			# Seleccionamos los datos de pexels
			$url .= "?" . http_build_query([
				'w' => $width,
				'height' => $height,
				'auto' => 'compress',
				'cs' => 'tinysrgb',
				'dpr' => 1,
				'fit' => 'crop'
			]);
		} elseif($page == 'unsplash') $url .= "/{$width}x{$height}";
		return $url;
	}

	private function verify_image(string $where = '') {
		$tsUser = new tsUser;
		$page = $_POST['setting_type'];
		$imageid = $_POST['setting_id']; 

		$tabla = ($where == 'perfil') ? 'u_settings' : 'w_settings';
		$st2 = ($where == 'perfil') ? 'user_id' : 'wid';
		$id = ($where == 'perfil') ? (int)$tsUser->uid : 1;

		$data = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT setting_type, setting_id FROM $tabla WHERE $st2 = $id"));
		return $where . '_' . md5($data['setting_type'] . $data['setting_id']);
	}

	private function DownloadImageLocal(string $where = '', string $origin = '', string $name = '', array $size = []) {
		$tsCore = new tsCore;
		$data_image = file_get_contents($origin);
	   if($data_image == false) exit("Error al leer los datos de $origin...\n");
	   // RUTA
	   $ruta = ROUTEDESCARGAS . $name . ".webp";
		if(!file_exists($ruta) OR self::verify_image($where) != $name) {
			$imagenfs = imagecreatefromstring($data_image);
			if($imagenfs == false) exit("Error al crear la imagen desde los datos de $origin...\n");

			$orw = imagesx($imagenfs);
			$orh = imagesy($imagenfs);

			$pos = $size['position'];
			array_shift($size);

			$seleccionar = [
			   ['x' => 0, 'y' => 0, ...$size],
			   ['x' => 0, 'y' => ($orh - $size['height']) / 2, ...$size],
			   ['x' => 0, 'y' => $orh - $size['height'], ...$size],
			   ['x' => $orw - $size['width'], 'y' => 0, ...$size],
			   ['x' => $orw - $size['width'], 'y' => ($orh - $size['height']) / 2, ...$size],
			   ['x' => $orw - $size['width'], 'y' => $orh - $size['height'], ...$size],
			   ['x' => ($orw - $size['width']) / 2, 'y' => 0, ...$size],
			   ['x' => ($orw - $size['width']) / 2, 'y' => ($orh - $size['height']) / 2, ...$size],
			   ['x' => ($orw - $size['width']) / 2, 'y' => $orh - $size['height'], ...$size],
			];
			$imagencrop = imagecrop($imagenfs, $seleccionar[$pos]);
			imagewebp($imagencrop, $ruta, 90);
			imagedestroy($imagenfs);
			if ($imagencrop !== false) {
				imagedestroy($imagencrop);
			}
			/*file_put_contents(, $data_image);
	      $imagen_webp = @imagecreatefromwebp(ROUTEDESCARGAS . $name . ".webp");
	      @imagewebp($imagen_webp, $name . ".webp", 80);*/
	   }

	   return $tsCore->settings['downloads'] . "/$name.webp?" . uniqid();
	}

	private function NewImagelocal(string $page = '', string $where = '', string $origin = '', array $size = []) {
		$tsUser = new tsUser;
		# Creamos la ruta de la imagen
		$name_encode = $where . '_' . md5($page . $_POST["setting_id"]);
		# ../files/downloads/*.webp
		$route_image = ROUTEDESCARGAS . $name_encode . ".webp";
		# Comprobamos que exista la imagen
		if(file_exists($route_image)):
			# No existe entoces, la descargaremos y solo si es 1er usuario o admin
			if((int)$tsUser->is_admod OR (int)$tsUser->uid === 1) {
				$response = self::DownloadImageLocal($where, $origin, $name_encode, $size);
			} else $response = self::DownloadImageLocal($where, $origin, $name_encode, $size);
		else:
			$response = self::DownloadImageLocal($where, $origin, $name_encode, $size);
		endif;
		return $response;
	}

	public function save_background(string $where = '') {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		//
		$id = ($where == 'perfil') ? (int)$tsUser->uid : 1;

		$tabla = ($where == 'perfil') ? 'u_settings' : 'w_settings';
		$column = ($where == 'perfil' ? 'user_id' : 'wid') . " = $id";
		// 
		$data = self::postSecure(false, 'setting_type');
		# Primero verificamos si existe
		$exists = verify_data([__FILE__, __LINE__], 'setting_id', $tabla, $column);
		if($exists) {
			$page = $data["setting_type"];
			if(db_exec([__FILE__, __LINE__], 'query', "UPDATE $tabla SET {$tsCore->getIUP($data)} WHERE $column")) {
				$sizes = [
					'position' => $_POST['setting_position'],
					'width' => $_POST['setting_width'], 
					'height' => $_POST['setting_height']
				];
				self::NewImagelocal($page, $where, self::BuildUrl($page), $sizes);
				$response = "1: Se ha actualizado correctamente.";
			} else $response = "0: Hubo un error.";
			return $response;
		}
	}

	public function verify_background(string $where = '') {
		$tsUser = new tsUser;
		$tsCore = new tsCore;
		
		$id = ($where == 'perfil') ? (int)$tsUser->uid : 1;

		$tabla = ($where == 'perfil') ? 'u_settings' : 'w_settings';
		$column = ($where == 'perfil') ? 'user_id' : 'wid';
	
		$data = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT setting_attachment, setting_position, setting_repeat, setting_size FROM $tabla WHERE $column = $id"));

		$props_background = ['attachment', 'position', 'repeat'];
		foreach($props_background as $prop)
			$style[] = "background-$prop: " . $this->$prop[$data["setting_{$prop}"]];
		$style[] = "background-size: " . $data["setting_size"];

		return [
			'url' => $tsCore->settings['downloads'] . '/' .self::verify_image($where) . '.webp',
			'styles' => join('; ', $style)
		];
	}


}