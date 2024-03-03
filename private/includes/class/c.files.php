<?php if ( ! defined('SYNTAXISLITEV3')) exit('No se permite el acceso directo al script');

/**
 * @name    c.files.php
 * @author  Kmario19
 * @upgrade Miguel92
 * @copyright 2020-2024
*/

class tsFiles {

	private $tipos_carpetas = [
		1 => 'documentos',
		2 => 'imagenes',
		3 => 'musica',
		4 => 'privada',
		5 => 'protegido',
		6 => 'publico',
		7 => 'videos'
	];

	/**
	 * @access private
    * @uses Obtenemos información del archivo extension, nombre, etc.
	 * @param string
	 * @param string extension | filename | basename
	 * @return string
	*/
	private function getInfoFile(string $file = '', string $type = 'extension'):string {
		$params = [
			'extension' => PATHINFO_EXTENSION,
			'basename' => PATHINFO_BASENAME,
			'filename' => PATHINFO_FILENAME
		];
		return pathinfo($file, $params[$type]);
	}

	/**
	 * @access private
    * @uses Obtenemos los iconos para usar
    * @param string
	 * @return array
	*/
	private function getIcons(string $extension = '') {
		$icons = array_filter(glob(ROUTETHEMEACTIVE . 'images/files/*'), 'is_file');
		foreach ($icons as $key => $icon) {
			$filename = self::getInfoFile($icon, 'filename');
			if (!preg_match('/^carpeta-/', $filename)) {
				$extensiones[$filename] = $filename;
				if($filename == 'doc') $extensiones[$filename] = 'docx';
				if($filename == 'xls') $extensiones[$filename] = 'xlsx';
				if($filename == 'mdb') $extensiones[$filename] = 'accdb';
			}
		}
		if(!in_array($extension, $extensiones)) $extensiones[$extension] = 'archivo';
		return $extensiones[$extension];		
	}

	/**
	 * @access private
    * @uses Comprobamos si es administrador!
	 * @return string
	*/
	private function getAdmin(string $fix = '', string $add = '') {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
      // Solo si esta la vista de moderacion activa
      $isAdmod = "AND {$fix}user_activo = 1 AND {$fix}user_baneado = 0" . (!empty($add) ? " $add" : '');
      if($tsUser->is_admod AND (int)$tsCore->settings['c_see_mod'] === 1) $isAdmod = '';
      //
      return $isAdmod;
   }

	/**
	 * @access private
    * @uses Obtenemos todos los mime
	 * @return string
	*/
	private function MIME(string $ext = ''):string {
		// Texto
		$txts = ['css', 'html', 'js', 'json', 'txt'];
		foreach($txts as $txt) $mime[$txt] = 'txt/' . ($txt == 'js' ? 'javascript' : $txt);
		// Imagenes
		$imgs = ['gif', 'jpeg', 'jpg', 'png', 'webp', 'svg'];
		foreach($imgs as $img) $mime[$img] = "image/$img" . ($img == 'svg' ? '+xml' : '');
		// Audio
		$auds = ['mpeg', 'ogg', 'wav', 'mp3'];
		foreach($auds as $aud) $mime[$aud] = "audio/$aud";
		// Video
		$vids = ['mp4', 'ogg', 'webm'];
		foreach($vids as $vid) $mime[$vid] = "video/$vid";
		// Fuentes
		$fonts = ['otf', 'ttf', 'woff', 'woff2'];
		foreach($fonts as $font) $mime[$font] = "font/$font";
		$mime = [
			// Aplicacion
			'docx' => 'application/msword',
			'pdf' => 'application/pdf',
			'ppt' => 'application/vnd.ms-powerpoint',
			'xlsx' => 'application/vnd.ms-excel',
			'xml' => 'application/xml',
			'zip' => 'application/zip',
		];
		// En caso que no este, enviamos el normal
		$rsp = ($mime[$ext] == NULL) ? 'application/octet-stream' : $mime[$ext];
		return $rsp;
	}

	/**
	 * @access private
    * @uses Convertimos los segundos a minutos
	 * @return string
	*/
	private function convertirms($segundos) {
   	$minutos = floor($segundos / 60);
   	$segundos = $segundos % 60;
   	return sprintf("%02d:%02d", $minutos, $segundos);
	}

	/**
	 * @access public
    * @uses Obtenemos información del archivo a descargar
    * @param string
	 * @return array
	*/
	public function getData(string $code = ''):array {
		return db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT arc_name, arc_code, arc_ext, arc_private FROM files_archivos WHERE arc_code = '$code' LIMIT 1"));
	}

	/**
	 * @access public
    * @uses Obtenemos el peso del archivo en bytes, kb, mb, gb, etc.
	 * @param string
	 * @param int 
	 * @return string
	*/
	public function formatBytes($size = NULL, int $decimals = 2):string {
	   if ($size === NULL) return '0 Bytes';
	   $k = 1024;
	   $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	   $i = floor(log($size, $k));
	   //$formattedSize = number_format($size / pow($k, $i), $decimals);
	   $formattedSize = number_format($size / pow($k, $i), ($i < 2) ? 0 : $decimals);
	   return $formattedSize . $sizes[$i];
	}

	/**
	 * @access public
    * @uses Obtenemos la información del archivo
	 * @return Object json
	*/
	public function getOnlyInfo() {
		# Obtenemos el archivo de $_FILES
		if(isset($_FILES['archivo']) OR isset($_GET['id'])) {
			if(isset($_GET['id'])) {
				$id = (int)$_GET['id'];
				$data = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT arc_id, arc_user, arc_name, arc_code, arc_weight, arc_type, arc_ext, arc_downloads, arc_comments, arc_private, user_id, user_name FROM files_archivos LEFT JOIN u_miembros ON user_id = arc_user WHERE arc_id = $id"));
				$data = [
					'user' => $data['user_name'],
					'ext' => $data['arc_ext'],
					'format' => $data['arc_type'],
					'name' => $data['arc_name'],
					'weight' => $data['arc_weight'],
					'downloads' => $data['arc_downloads'],
					'private' => $data['arc_private'] ? 'Privado' : 'Publico',
					'icon' => self::getIcons($data['arc_ext'])
				];
			} else {
				$archivo = $_FILES['archivo'];
				// Si esta vacio.
				if(empty($archivo['name'])) return '0: No has seleccionado ning&uacute;n archivo.';
				$extension = self::getInfoFile($archivo['name'], 'extension');
				$data = [
					'ext' => $extension,
					'format' => $archivo['type'],
					'name' => self::getInfoFile($archivo['name'], 'filename'),
					'weight' => self::formatBytes($archivo['size']),
					'icon' => self::getIcons($extension)
				];
			}
			return json_encode($data);
		}
	}

	/**
	 * @access public
    * @uses Subimos el archivo y generamos nuevo nombre
	 * @return string
	*/
	public function fileUpload() {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		$OneGB = 1048576; // 1GB
		# Obtenemos el archivo de $_FILES
		if(isset($_FILES['archivo'])) {
			$archivo = $_FILES['archivo'];
			// Si esta vacio.
			if(empty($archivo['name'])) return '0: No has seleccionado ning&uacute;n archivo.';

			if((int)$tsCore->settings['c_max_upload'] >= 0 || $archivo['size'] <= (int)$tsCore->settings['c_max_upload'] * $OneGB) {
				// PERMISOS Y RESTRICCIONES
				switch($tsCore->settings['c_files_type']) {
					case 1:
						$ext_perm = explode(',',$tsCore->settings['c_files_ext']);
						if(!in_array($ext, $ext_perm)) return "0: Solo se permiten archivos con extensi&oacute;n <strong>'.{$tsCore->settings['c_files_ext']}.'</strong>";
					break;
					case 2:				
						$ext_perm = explode(',',$tsCore->settings['c_files_ext']);
						if(in_array($ext, $ext_perm)) return "0: No se permiten archivos con extensi&oacute;n <strong>{$tsCore->settings['c_files_ext']}</strong>";
					break;
					case 3:
						return "0: No se permite la subida de archivos.";
					break;
				}
				$privado = isset($_POST['privado']) ? 1 : 0;
				// Subimos archivo a una carpeta, o de adentro de una carpeta
				$carpeta = isset($_POST['carpeta_id']) ? (int)$_POST['carpeta_id'] : (int)$_POST['carpeta'];
				// Información del archivo
				$extension = self::getInfoFile($archivo['name'], 'extension');
				$formato = $archivo['type'];
				$nombre = self::getInfoFile($archivo['name'], 'filename');
				$peso = self::formatBytes($archivo['size']);
				// PARA EL DIRECTORIO
				$nuevo_nombre = 'sl2' . md5(uniqid($nombre));
				$destino = ROUTEARCHIVOS . "$nuevo_nombre.$extension";
				$tiempo = time();
				// SI HAY PROBLEMAS CON LA SUBIDA, NO CONTINUAMOS
				if ($archivo["error"] > 0) return "0: Error: ".$_FILES["file"]["error"];
				// ALMACENAMOS EL ARCHIVO
				else move_uploaded_file($archivo['tmp_name'], $destino);
				// INSERTAMOS
				$ip = $_SERVER['X_FORWARDED_FOR'] ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
				if(!filter_var($ip, FILTER_VALIDATE_IP)) return '0: Su ip no se pudo validar.';
				if(db_exec([__FILE__, __LINE__], 'query', "INSERT INTO files_archivos (arc_user, arc_name, arc_code, arc_weight, arc_type, arc_ext, arc_private, arc_status, arc_folder, arc_date, arc_ip) VALUES ({$tsUser->uid}, '$nombre', '$nuevo_nombre', '$peso', '$formato', '$extension', $privado, 1, $carpeta, $tiempo, '$ip')")) {					//
					return "1: <a href=\"{$tsCore->settings['url']}/files/archivos/$nuevo_nombre\"><strong>{$archivo['name']}</strong></a> subido exitosamente.";
				} else return '0: Ocurri&oacute; un error al subir el archivo, int&eacute;ntalo m&aacute;s tarde';
			} else return "0: El archivo que intentas subir excede los <strong>".self::formatBytes($tsCore->settings['c_max_upload'])."</strong> permitidos.";
		}
	}

	/**
	 * @access public
    * @uses Creamos la una nueva carpeta.
	 * @return string
	*/
	public function createNewFolder() {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		// Comprobamos que tenga un titulo
		if(empty($_POST['car_name'])) return ['type' => 0, 'msg' => 'La carpeta debe tener un nombre.'];
		// Almacenamos algunos datos para verificar antes de añadir
		$name = $tsCore->setSecure($_POST['car_name']);
		$seo = strtolower($tsCore->setSEO($name));
		$private = (isset($_POST['car_private']) OR $_POST´['car_private'] != NULL) ? 1 : 0;
		$type = (int)$_POST['carpeta'];
		$uid = $tsUser->uid;
		$time = time();
		// Crearemos la contraseña más segura
		$pass = !empty($_POST['car_pass']) ? $tsCore->passwordSL2($seo, $tsCore->setSecure($_POST['car_pass'])) : '';
		// Preguntamos si existe la carpeta
		$check = db_exec('fetch_row', db_exec([__FILE__, __LINE__], 'query', "SELECT car_name FROM files_carpeta WHERE car_name = '$name' LIMIT 1"))[0];
		if(!empty($check)) return ['type' => 0, 'msg' => 'Esta carpeta ya existe!'];
		// Si no existe, la crearemos
		if(db_exec([__FILE__, __LINE__], 'query', "INSERT INTO files_carpeta (car_user, car_name, car_seo, car_pass, car_date, car_type, car_private, car_status) VALUES($uid, '$name', '$seo', '$pass', $time, $type, $private, 1)")) {
			return ['type' => 1, 'msg' => 'La carpeta se creo.', 'data' => [
				'name' => $name, 
				'seo' => $seo, 
				'img' => (empty($pass) ? $this->tipos_carpetas[$type] : ($private == 1 ? 'privada' : 'protegido')),
				'enc' => !empty($pass)
			]];
		} else return ['type' => 0, 'msg' => 'No se pudo crear la carpeta'];
	}

	/**
	 * @access public
    * @uses Obtenemos los tipos de carpetas
	 * @return array
	*/
	public function getTypeOfFolders(string $action = ''):array {
		$tsUser = new tsUser;
		if((int)$tsUser->is_member) {
			// Sin contraseña - car_pass
			$typeof = result_array(db_exec([__FILE__, __LINE__], 'query', "SELECT ct_id, ct_name FROM files_carpeta_tipos"));
			if($action === 'crear') {
				foreach ($typeof as $key => $type) {
					if(!in_array($type['ct_name'], ['privada', 'protegido'])) $nwrtn[$key] = $type;
				}
			}
			return ($action === 'crear') ? $nwrtn : $typeof;
		}
	}

	/**
	 * @access public
    * @uses Obtenemos todas las carpetas del usuario
	 * @return array
	*/
	public function getFolders():array {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		//if((int)$tsUser->is_member) {
			$uid = (int)$tsUser->uid;
			// 
			$folders = result_array(db_exec([__FILE__, __LINE__], 'query', "SELECT car_id, car_user, car_name, car_seo, car_date, car_pass, car_private, car_type, car_status, user_id, user_name, ct_id, ct_name FROM files_carpeta LEFT JOIN u_miembros ON car_user = user_id LEFT JOIN files_carpeta_tipos ON ct_id = car_type WHERE car_user = $uid AND car_status = 1"));
			foreach($folders as $id => $folder) {
				// Contamos la cantidad de archivos por carpeta
				$folders[$id]['arc_total'] = db_exec('fetch_row', db_exec([__FILE__, __LINE__], 'query', "SELECT COUNT(arc_id) FROM files_archivos WHERE arc_folder = {$folder['car_id']}"))[0];
				$folders[$id]['ct_name'] = ($folder['car_type'] === 0) ? 'publico' : (!empty($folder['car_pass']) ? 'protegido' : ((int)$folder['car_private'] == 1 ? 'privada' : $folder['ct_name']));
			}
			return $folders;
		//}
	}

	/**
	 * @access public
    * @uses Obtenemos la carpeta del usuario
	 * @return array
	*/
	public function getFolder() {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		$tipo = $tsCore->setSecure($_GET['action']);
		$carpeta = $tsCore->setSecure($_GET['file']);
		// Preguntamos si es su carpeta
		$miCarpeta = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT car_user, car_name, car_status, car_type, car_private, car_pass FROM files_carpeta WHERE car_seo = '$carpeta'"));
		// Carpeta privada
		if((int)$tsUser->uid != (int)$miCarpeta['car_user'] AND (int)$miCarpeta['car_private'] == 1) return [
				'titulo' => 'Opps!', 
				'mensaje' => 'Esta carpeta es privada, no tienes acceso.'
			];
		// Carpeta protegida
		elseif(!empty($miCarpeta['car_pass'])) 
			return [
				'titulo' => 'Opps!', 
				'mensaje' => 'Esta carpeta esta protegido con contraseña y no tienes acceso.'
			];
		elseif($miCarpeta['car_type'] < 6 OR $miCarpeta['car_type'] > 6) 
			return [
				'titulo' => 'Lo siento', 
				'mensaje' => 'Solo se pueden ver las carpetas públicas.'
			];
		$admin = self::getAdmin();
		// Limitamos
	   $max = 12; // MAXIMO A MOSTRAR
	   $limit = $tsCore->setPageLimit($max, true);
		$data['nombre'] = $miCarpeta['car_name'];
		$data['archivos'] = result_array(db_exec([__FILE__, __LINE__], 'query', "SELECT car_name, car_seo, car_pass, car_date, car_type, car_private, car_status, arc_id, arc_name, arc_code, arc_ext, arc_weight, arc_comments, arc_downloads, arc_private, arc_status, arc_date, arc_ip, user_name, user_activo, user_baneado FROM files_carpeta LEFT JOIN files_archivos ON arc_folder = car_id LEFT JOIN u_miembros ON arc_user = user_id WHERE car_seo = '$carpeta' $admin LIMIT $limit"));
		// PAGINAS
	    list($total) = db_exec('fetch_row', db_exec([__FILE__, __LINE__], 'query', "SELECT COUNT(arc_id) FROM files_archivos LEFT JOIN files_carpeta ON car_id = arc_folder WHERE car_seo = '$carpeta' AND arc_status = 1"));
	    $data['pages'] = $tsCore->pageIndex("{$tsCore->settings['url']}/files/$tipo/$carpeta?ver", $_GET['s'], $total, $max);
		return $data;
	}

	/**
	 * @access public
    * @uses Obtenemos todos los archivos subidos
	 * @return array
	*/
	public function getFilesUploaded() {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		// Filtrar u Ordenar
		$order = isset($_GET['o']) ? "file.arc_{$_GET['o']}" : ($_GET['o'] == 'folder' ? 'folder.car_name' : 'file.arc_date');
		$mode = !isset($_GET['m']) ? 'DESC' : ($_GET['m'] === 'a' ? 'ASC' : 'DESC');
		$all = !isset($_GET['a']) ? '' : ($_GET['a'] === 'all' ? '' : " AND u.user_id = {$tsUser->uid}");
		$admin = self::getAdmin('u.');
		// Limitamos
      $max = 10; // MAXIMO A MOSTRAR
      $limit = $tsCore->setPageLimit($max, true);
		// Realizamos la consulta
		$data['files'] = result_array(db_exec([__FILE__, __LINE__], 'query', "SELECT file.arc_id, file.arc_user, file.arc_name, file.arc_code, file.arc_ext, file.arc_downloads, file.arc_private, file.arc_status, file.arc_date, file.arc_ip, folder.car_user, folder.car_name, folder.car_seo, folder.car_pass, folder.car_date, folder.car_private, folder.car_status, u.user_id, u.user_name FROM files_archivos AS file LEFT JOIN files_carpeta AS folder ON folder.car_id = file.arc_folder LEFT JOIN u_miembros AS u ON u.user_id = file.arc_user WHERE file.arc_status = 1 $admin$all ORDER BY $order $mode LIMIT $limit"));
		foreach ($data['files'] as $key => $file) {
			$data['files'][$key]['arc_ico'] = self::getIcons($file['arc_ext']);
		}
		// PAGINAS
      list($total) = db_exec('fetch_row', db_exec([__FILE__, __LINE__], 'query', 'SELECT COUNT(*) FROM files_archivos WHERE arc_status = 1'));
      $o = empty($_GET['o']) ? 'date' : $_GET['o'];
      $m = empty($_GET['m']) ? 'd' : $_GET['m'];
      $a = empty($_GET['a']) ? 'all' : $_GET['a'];
      $data['pages'] = $tsCore->pageIndex("{$tsCore->settings['url']}/files/?o=$o&m=$m&a=$a", $_GET['s'], $total, $max);
		return $data;
	}

	/**
	 * @access public
    * @uses Obtenemos el archivo subido
	 * @return array
	*/
	public function getFileUploaded() {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		// En caso que sea privado
		$archivo = $tsCore->setSecure($_GET['file']);
		//if($tsUser->is_member) $data['error'] 'Debes iniciar sesión, para ver el archivo.';
		$data['data'] = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT f.arc_id, f.arc_user, f.arc_name, f.arc_code, f.arc_ext, f.arc_downloads, f.arc_private, f.arc_status, f.arc_date, f.arc_weight, f.arc_ip, c.car_user, c.car_name, c.car_seo, c.car_pass, c.car_date, c.car_private, c.car_status, u.user_id FROM files_archivos AS f LEFT JOIN files_carpeta AS c ON c.car_id = f.arc_folder LEFT JOIN u_miembros AS u ON u.user_id = f.arc_user WHERE f.arc_status = 1 AND f.arc_code = '$archivo'"));
		$data['data']['url_file'] = $tsCore->settings['files'] . "/archivos/{$data['data']['arc_code']}.{$data['data']['arc_ext']}";
		$data['author'] = self::getDataAuthor($data['data']['user_id']);
		$data['fav'] = self::getFavourites($data['data']['user_id'], $data['data']['arc_id']);
		return $data;
	}

	/**
	 * @access public
    * @uses Obtenemos información del autor
	 * @return array
	*/
	public function getDataAuthor(int $uid = 0) {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		//
		$admin = self::getAdmin('u.');
		$sql = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT u.user_name, u.user_email, u.user_activo, u.user_baneado, r.r_name, r.r_color FROM u_miembros AS u LEFT JOIN u_rangos AS r ON u.user_rango = r.rango_id WHERE u.user_id = $uid $admin"));
		$sql['user_avatar'] = $tsCore->getAvatar($uid);
		return $sql;
	}

	/**
	 * @access public
    * @uses Obtenemos el archivo subido
	 * @return array
	*/
	public function getFavourites(int $uid = 0, int $fid = 0) {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		$sql['total'] = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT COUNT(fav_file) AS total FROM files_favoritos LEFT JOIN u_miembros ON fav_user = user_id WHERE fav_file = $fid"))['total'];
		//
		$sql['data'] = result_array(db_exec([__FILE__, __LINE__], 'query', "SELECT user_id, user_name, fav_date, arc_name FROM u_miembros LEFT JOIN files_favoritos ON fav_user = user_id LEFT JOIN files_archivos ON fav_file = arc_id WHERE fav_file = $fid ORDER BY fav_date DESC LIMIT 8"));
		foreach ($sql['data'] as $key => $a) {
			$sql['data'][$key]['user_avatar'] = $tsCore->getAvatar($a['user_id']);
		}
		return $sql;
	}

	public function fileFavourite() {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		//
		$uid = (int)$tsUser->uid;
		$fid = (int)$_POST['arc_id'];
		$time = time();
		// Compobamos que no lo tenga agregado
		$fav = db_exec('num_rows', db_exec([__FILE__, __LINE__], 'query', "SELECT fav_id FROM files_favoritos WHERE fav_user = $uid AND fav_file = $fid"));
		if($fav !== 0) return '0: Ya lo tienes en favoritos.';
		if(db_exec([__FILE__, __LINE__], 'query', "INSERT INTO files_favoritos (fav_file, fav_user, fav_date) VALUES ($fid, $uid, $time)")) {
			return '1: Agregados a favoritos.';
		}
	}

	/**
	 * @access public
    * @uses Obtenemos todos los mime
	 * @return string
	*/
	public function getMp3Info(string $archivo = '', bool $default = true) {
		$tsCore = new tsCore;
		include ROUTEEXTRAS . 'Mp3Info.php';
		
		$archivo = self::getInfoFile($archivo, 'basename');
		$audio = new Mp3Info(ROUTEARCHIVOS . $archivo, $default );
		//
		$informacion = [
			'title' => $audio->tags2['TIT2'], 
			'duration' => floor($audio->duration / 60).'min '.floor($audio->duration % 60). 'sec', 
			'kbps' => $audio->bitRate/1000, 
			'channel' => $audio->channel,
		];
		return $informacion;
	}

	/**
	 * @access public
    * @uses Obtenemos información del archivo
	 * @return string
	*/
	public function getTxtPhp($filename = NULL) {
		$filename = self::getInfoFile($filename, 'basename');
		$archivo = ROUTEARCHIVOS . $filename;
		$aCadena = file_get_contents($archivo);
    	return $aCadena;

	}

	/**
	 * @access public
    * @uses Descargamos el archivo!
	*/
	public function DownloadFile() {
		$tsCore = new tsCore;
		$tsUser = new tsUser;
		//
		$nombre = $tsCore->setSecure($_GET['file']);
		$data = self::getData($nombre);
		if(!$tsUser->is_member OR (int)$data['arc_private'] == 1) return false;
		$ext = $data['arc_ext'];
		$archivo = ROUTEARCHIVOS . "$nombre." . $ext ;
		$nuevo_nombre = $data['arc_name'] . ".$ext";
		if (file_exists($archivo)) {
			// Configurar encabezados para la descarga
			header('Content-Description: File Transfer');
			header('Content-Type: ' . self::MIME($ext));
			header('Content-Disposition: attachment; filename=SL2_'  . $nuevo_nombre);
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($archivo));
			// Leer el archivo y enviar su contenido al navegador
			if(readfile($archivo)) {
				// Contamos la descargas
				db_exec([__FILE__, __LINE__], 'query', "UPDATE files_archivos SET arc_downloads = arc_downloads + 1 WHERE arc_code = '$nombre'");
				header("Location: {$tsCore->settings['url']}/files/");
			}
			exit;
		// En caso que no exista mostrarémos este mensaje!
		} else echo 'El archivo no existe.';
	}

	public function moveFile() {
		$tsUser = new tsUser;
		//
		$aid = (int)$_POST['arc_id'];
		$fid = (int)$_POST['arc_folder'];
		// Buscamos el archivo
		$sql = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT arc_id, arc_user, arc_folder FROM files_archivos WHERE arc_id = $aid"));
		if(empty($sql['arc_id'])) return '0: El archivo no existe';
		if((int)$sql['arc_folder'] === $fid) return '0: No puedes mover a la misma carpeta.';
		if((int)$tsUser->uid != (int)$sql['arc_user']) return '0: Solo puedes mover tus archivos.';
		//
		if(db_exec([__FILE__, __LINE__], 'query', "UPDATE files_archivos SET arc_folder = $fid WHERE arc_id = $aid")) return '1: El archivo se movió con exito.';		
	}
}