<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * @name    c.files.php
 * @author  Kmario19
 * @upgrade Miguel92
 * @copyright 2020
*/

class tsFiles {
	/*
		BUSCAR EL TIPO DE ARCHIVO EN SU NOMBRE: NO HAY DE OTRA -YAO
	*/	
	function ext_archivo($nombre = NULL) {		
		// Separamos las palabras
		$palabras = explode('.',$nombre);
		// Despues del punto es la extension
		$sep = safe_count($palabras)-1;
		// Sacamos la extension :D
		$ext = $palabras[$sep];
		//
		return $ext;
	}
	
	/*
		SACAR NOMBRE SIN EXTENSION
	*/
	function nombre_archivo($name, $ext) {
		// Separar .xxx del nombre del archivo
		$file = explode('.'.$ext,$name);
		// El nombre es el primero e,e
		$nombre = $file[0];
		//		
		return $nombre;
	}
	
	/*
		SIMPLE CONVERSION DE UNIDADES: KB, MB, GB
	*/
	function peso_archivo($size = NULL) {
		// Menores de 1Kb para Kb con maximo de 3 decimales
		if($size <= 1024) {
			$total = $size/1024;
			$total = number_format($total, 3);
			$total = $total.'KB';
		// Menores de 1Mb para Kb con un decimal	
		}elseif($size >= 1024 && $size <= 1048576) {
			$total = $size/1024;
			$total = number_format($total, 1);
			$total = $total.'KB';		
		// Menores de 1Gb para Mb con un decimal
		}elseif($size >= 1048576 && $size <= 1073741824) {
			$total = $size/1048576;
			$total = number_format($total, 1);
			$total = $total.'MB';
		// Si es mayor de 1Gb (poco probable) que muestre en Gb con dos decimales
		}elseif($size >= 1073741824) {
			$total = $size/1073741824;
			$total = number_format($total, 2);
			$total = $total.'GB';
		}
		//	
    	return $total;
	}
	
	/*
		SUBIR NUEVO ARCHIVO
	*/
	function newFile() {
		global $tsCore, $tsUser;
		//
		if(!empty($_FILES['archivo']['name'])) {
			// PESA MAS DE LO PERMITIDO?
			if($tsCore->settings['c_max_upload'] >= 0 || $_FILES['archivo']['size'] <= $tsCore->settings['c_max_upload']*1073741824) {
				// OBTENEMOS DATOS
				$archivo = $_FILES['archivo'];			
				$privado = empty($_POST['privado']) ? 0 : 1;
				// DESDE UNA CARPETA?
				$folder = empty($_GET['folderid']) ? 0 : intval($_GET['folderid']);
				// SOLO EXTENSION
				$ext = $this->ext_archivo($archivo['name']);
				// PERMISOS Y RESTRICCIONES
				switch($tsCore->settings['c_files_type']) {
					case 1:
						$ext_perm = explode(',',$tsCore->settings['c_files_ext']);
						if(!in_array($ext, $ext_perm)) return 'Solo se permiten archivos con extensi&oacute;n <b>'.$tsCore->settings['c_files_ext'].'</b>';
					break;
					case 2:				
						$ext_perm = explode(',',$tsCore->settings['c_files_ext']);
						if(in_array($ext, $ext_perm)) return 'No se permiten archivos con extensi&oacute;n <b>'.$tsCore->settings['c_files_ext'].'</b>';
					break;
					case 3:
						return 'No se permite la subida de archivos.';
					break;
				}
				// FORMATO
				$formato = $archivo['type'];
				// SOLO NOMBRE
				$nombre = substr($archivo['name'], 0, strripos($archivo['name'], '.'.$ext));
				$peso = $this->peso_archivo($archivo['size']);
				// PARA EL DIRECTORIO
				$url = $tsUser->uid.'_'.md5($archivo['name'].rand(0,100)).'.'.$ext;
				$destino = TS_FILES.'archivos/'.$url;
				// SI HAY PROBLEMAS CON LA SUBIDA, NO CONTINUAMOS
				if ($archivo["error"] > 0) { die("0: Error: ".$_FILES["file"]["error"]); }
				// ALMACENAMOS EL ARCHIVO
				else move_uploaded_file($archivo['tmp_name'], $destino);
				// INSERTAMOS
				$_SERVER['REMOTE_ADDR'] = $_SERVER['X_FORWARDED_FOR'] ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
				if(!filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) { die('0: Su ip no se pudo validar.'); }
				if(db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO `a_files` (f_nombre, f_url, f_fecha, f_peso, f_ext, f_tipo, f_user, f_privado, f_estado, f_folder, f_ip) VALUES (\''.$nombre.'\', \''.$url.'\', \''.time().'\', \''.$peso.'\', \''.$ext.'\', \''.$formato.'\', \''.$tsUser->uid.'\', \''.$privado.'\', \'1\', \''.(int)$folder.'\', \''.$_SERVER['REMOTE_ADDR'].'\')')) {
					//
					return '1: <a href="'.$tsCore->settings['url'].'/files/'.db_exec('insert_id').'/'.$tsCore->setSEO($nombre).'"><b>'.$archivo['name'].'</b></a> subido exitosamente.';
				} else return '0: Ocurri&oacute; un error al subir el archivo, int&eacute;ntalo m&aacute;s tarde';
			} else return '0: El archivo que intentas subir excede los <b>'.$tsCore->settings['c_max_upload'].'Mb</b> permitidos.';
		} else return '0: No has seleccionado ning&uacute;n archivo.';
		
	}
	
	/* 
		BORRAR ARCHIVO
	*/
	function deleteFile(){
		global $tsCore, $tsUser, $tsMonitor;
		//
		$file = $tsCore->setSecure($_POST['fileid']);
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_user, f_estado, f_ext, f_nombre, f_user FROM a_files WHERE file_id = \''.(int)$file.'\'');
		$data = db_exec('fetch_assoc', $query);
		// ES MIO O TIENE PERMISOS
		if($data['f_user'] == $tsUser->uid){
			// BORRAR ARCHIVO DEL SERVIDOR		
			$root = TS_FILES.'archivos/'.$data['f_url'];
       	unlink($root);
			// BORRAR DATOS ADICIONALES
			$file = (int)$file;
			db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_files WHERE file_id = " . $file);
			db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_favoritos WHERE fav_file = " . $file);
			db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_descargas WHERE d_file = " . $file);
			db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_comentarios WHERE com_file = " . $file);
            return '1: Se elimino el archivo correctamente.';				
		} elseif (!empty($tsUser->is_admod)) {
			// YA LO HABIA DESABILITADO?
			if($data['f_estado'] == 1) {
				db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_estado = \'0\' WHERE file_id = \''.(int)$file.'\'');
				// MANDAR AVISO AL USUARIO
				$aviso = 'Hola <b>'.$tsUser->getUserName($data['f_user'])."</b>\n\n Te informo que tu archivo <b>".$data['f_nombre'].".".$data['f_ext']."</b> ha sido desactivado temporalmente por <a href=\"#\" class=\"hovercard\" uid=\"".$tsUser->uid."\">".$tsUser->nick."</a>\n\n Estar&aacute; en revisi&oacute;n por incumplir con el protocolo de archivos.\n\nTe recomendamos estar al tanto de este reglamento para no tener este inconveniente de nuevo.\n\n Muchas gracias por entender!";
				$tsMonitor->setAviso($data['f_user'], 'Archivo eliminado', $aviso, 1);
				return '2: El archivo fue removido para su revision.<br /><br /> Borrar permanentemente desde la administraci&oacute;n o recarga esta p&aacute;gina.';
			} else return '0: El archivo ya est&aacute; desabilitado.';
		} else return '0: Lo que intentas hacer no est&aacute; permitido.';
	}
	
	/* 
		BORRAR ARCHIVO DEFINITIVO POR UN ADMINISTRADOR
	*/
	function admindeleteFile(){
		global $tsCore, $tsUser, $tsMonitor;
		//
		$fileid = $tsCore->setSecure($_POST['fileid']);
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_nombre, f_ext, f_user, f_url FROM a_files WHERE file_id = \''.(int)$fileid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// EXISTE EL ARCHIVO?
		if(!empty($data['file_id'])) {
			// ES MIO O TIENE PERMISOS
			if(!empty($tsUser->is_admod)){
				// MANDAR AVISO AL USUARIO ANTES DE BORRAR LOS DATOS
				$aviso = 'Hola <b>'.$tsUser->getUserName($data['f_user'])."</b>\n\n Te informo que tu archivo <b>".$data['f_nombre'].".".$data['f_ext']."</b> ha sido eliminado permanentemente por <a href=\"#\" class=\"hovercard\" uid=\"".$tsUser->uid."\">".$tsUser->nick."</a> por incumplir con el protocolo de archivos.\n\nTe recomendamos estar al tanto de este reglamento para no tener este inconveniente de nuevo.\n\n Muchas gracias por entender!";
				$tsMonitor->setAviso($data['f_user'], 'Archivo eliminado permanentemente', $aviso, 3);
				// BORRAR ARCHIVO DEL HOST			
				$root = TS_FILES.'archivos/'.$data['f_url'];
				unlink($root);
				// BORRAR DATOS ADICIONALES
				$fileid = (int)$fileid;
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_files WHERE file_id = {$fileid}");
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_favoritos WHERE fav_file = {$fileid}");
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_descargas WHERE d_file = {$fileid}");
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_comentarios WHERE com_file = {$fileid}");			
				//
				return '1: El archivo se ha eliminado correctamente.';				
			} else return '0: Lo que intentas hacer no est&aacute; permitido.';
		} else return '0: El archivo no existe o ya fu&eacute; eliminado permanentemente.';
	}
	/* 
		BORRAR ARCHIVOS SELECCIONADOS
	*/
	function delFiles(){
		global $tsCore, $tsUser, $tsMonitor;
		$elmts = explode(',', $_POST['files']);
		foreach($elmts as $file) {
			$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_url FROM a_files WHERE file_id = \''.(int)$file.'\' AND f_user = \''.$tsUser->uid.'\'');
			$dato = db_exec('fetch_assoc', $query);
			if($dato['file_id']>0) {
				// BORRAR ARCHIVO DEL SERVIDOR		
				$root = TS_FILES.'archivos/'.$dato['f_url'];
				unlink($root);
				// BORRAR DATOS ADICIONALES
				$file = (int)$file;
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_files WHERE file_id = " . $file);
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_favoritos WHERE fav_file = " . $file);
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_favoritos WHERE fav_file = " . $file);
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_descargas WHERE d_file = " . $file);
				db_exec(array(__FILE__, __LINE__), 'query', "DELETE FROM a_comentarios WHERE com_file = " . $file);
			}
		}
		return '1: Se han eliminado los archivos correctamente.';
	}
	/* 
		REACTIVAR ARCHIVO
	*/
	function reactivarFile(){
		global $tsCore, $tsUser, $tsMonitor;
		//
		$fileid = $tsCore->setSecure($_POST['fileid']);
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_estado, f_user, f_nombre, f_ext FROM a_files WHERE file_id = \''.(int)$fileid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// ES MIO O TIENE PERMISOS
		if(!empty($tsUser->is_admod)){	
			if($data['f_estado'] == 0) {	
				if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_estado = \'1\' WHERE file_id = \''.$fileid.'\'')) {
					// MANDAR AVISO AL USUARIO
					$aviso = 'Hola <b>'.$tsUser->getUserName($data['f_user'])."</b>\n\n Te informo que tu archivo <a href=".$tsCore->settings['url'].'/files/archivos/'.$data['file_id'].'/'.$tsCore->setSEO($data['f_nombre'])."><b>".$data['f_nombre'].".".$data['f_ext']."</b></a> ha sido reactivado por <a href=\"#\" class=\"hovercard\" uid=\"".$tsUser->uid."\">".$tsUser->nick."</a>.\n\n Disculpe las molestias!";
					$tsMonitor->setAviso($data['f_user'], 'Archivo reactivado', $aviso, 2);
					return '1: El archivo ha sido reactivado exitosamente.';
				} else return '0: Hubo un error al intentar procesar lo solicitado.';
			} else return '0: Este archivo ya est&aacute; activo.';
		} else return '0: Lo que intentas hacer no est&aacute; permitido.';
	}
	
	/* 
		EDITAR ARCHIVO
	*/
	function editFile(){
		global $tsCore, $tsUser;
		//
		$fileid = $tsCore->setSecure($_POST['fileid']);
		$name = $tsCore->setSecure($_POST['nombre']);
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_url, f_user FROM a_files WHERE file_id = \''.$fileid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// ES MIO O TIENE PERMISOS
		if(!empty($data['file_id'])){
			if($data['f_user'] == $tsUser->uid || !empty($tsUser->is_admod)) {			
				if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_nombre = \''.$name.'\' WHERE file_id = \''.$fileid.'\'')) {
					return '1: Cambio de nombre exitoso.';
				} else return '0: Hubo un error al intentar procesar lo solicitado.';					
			} else return '0: Lo que intentas hacer no est&aacute; permitido.';
		} else return '0: El archivo no existe.';
	}
	
	/*
		CAMBIAR PRIVACIDAD
	*/
	function cambioPrivado() {
		global $tsCore, $tsUser;
		//
		$fileid = $tsCore->setSecure($_POST['fileid']);
		$privado = $tsCore->setSecure($_POST['privado']);		
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_url, f_user FROM a_files WHERE file_id = \''.$fileid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// ES MIO O TIENE PERMISOS
		if(!empty($data['file_id'])){
			if($data['f_user'] == $tsUser->uid || !empty($tsUser->is_admod)) {
				if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_privado = '.$privado.' WHERE file_id = '.$fileid))
					return "1: Cambio de privacidad exitoso.";
				else return '0: Hubo un error al intentar procesar lo solicitado.';		
			} else return '0: Lo que intentas hacer no est&aacute; permitido.';
		} else return '0: El archivo no existe.';
	}
	
	/*
		VER ARCHIVO
	*/
	function verArchivo() {
		global $tsCore, $tsUser;
		$fileid = $tsCore->setSecure($_GET['fileid']);
		// EL ARCHIVO EXISTE?
		$q = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(a.file_id) FROM a_files AS a LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE a.file_id = '.$fileid.' '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'AND a.f_estado = \'1\' AND u.user_activo = \'1\' && u.user_baneado = \'0\'').' LIMIT 1'));
		if($q[0] == 1) {
			$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.*, u.user_id, u.user_name FROM a_files AS a LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE a.file_id = \''.(int)$fileid.'\' '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'AND u.user_activo = \'1\' && u.user_baneado = \'0\'').' LIMIT 1');	
			$data['data'] = db_exec('fetch_assoc', $query);
			// ES PRIVADO?
			if($data['data']['f_privado'] != 1 and $data['data']['f_user'] != $tsUser->uid or $tsUser->is_admod or $data['data']['f_user'] == $tsUser->uid) {
				// QUIENES HAN DESCARGADO
				$q1 = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.d_fecha, a.d_user, a.d_total, u.user_name FROM a_descargas AS a LEFT JOIN u_miembros AS u ON u.user_id = a.d_user WHERE a.d_file = '.$fileid.' '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'AND u.user_activo = \'1\' && u.user_baneado = \'0\'').' ORDER BY a.d_fecha DESC LIMIT 15');
				$data['users'] = result_array($q1);				
				// FAVORITOS
				$q2 = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.fav_user, a.fav_fecha, u.user_name FROM a_favoritos AS a LEFT JOIN u_miembros AS u ON u.user_id = a.fav_user WHERE a.fav_file = '.$fileid.' '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'AND u.user_activo = \'1\' && u.user_baneado = \'0\'').' ORDER BY a.fav_fecha DESC LIMIT 15');
				$data['favoritos'] = result_array($q2);
				$data['total']['favoritos'] = db_exec('num_rows', $q2);
				// YA LO AGREGUE A FAVORITOS?
				$q3 = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT fav_id FROM a_favoritos WHERE fav_file = '.$fileid.' AND fav_user ='.$tsUser->uid);
				$data['mifav'] = db_exec('fetch_assoc', $q3);
				if(db_exec('num_rows', $q3) == 1) $data['mifav']['act'] = 1;
				else $data['mifav']['act'] = 0;
				//
				return $data;
			} else return 'Este archivo es privado y no puedes descargarlo.';
		} else return 'El archivo no existe o ha sido eliminado.';
	}
	
	/*
		OBTENEMOS DATOS DEL ARCHIVO PARA FORZAR DESCARGA
	*/
	function bajarArchivo() {
		global $tsCore;
		//
		$fileid = $tsCore->setSecure($_GET['fileid']);
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT f_url, f_ext, f_tipo, f_privado, f_nombre FROM a_files WHERE file_id = \''.(int)$fileid.'\'');		
		$data = db_exec('fetch_assoc', $query);
		if(!empty($data['f_nombre'])) {
			if($data['f_privado'] == 0) {
				return $data;
			} else return '0: Este archivo es privado y no puedes descargarlo.';
		} else return '0: El archivo no existe.';
	}
	/*
		ARCHIVOS POR USER
	*/
	function filesUser($userid = NULL, $folderid = NULL) {
		global $tsCore, $tsUser;
		// ES MIO O TIENE PERMISOS?
		if($tsUser->is_admod) $where = ($tsCore->settings['c_see_mod'] == 1) ? '' : ' AND u.user_activo = \'1\' && u.user_baneado = \'0\' AND a.f_estado = \'1\'';
		else $where = ($userid == $tsUser->uid) ? ' AND a.f_estado = \'1\'' : ' AND a.f_estado = \'1\' AND a.f_privado = \'0\'';	
		// ORDEN
		if(!empty($_GET['o'])) $order = 'a.f_'.$_GET['o'];
		else $order = 'a.f_fecha';
		if(!empty($_GET['f']) && $_GET['f'] == 'a') $forma = 'ASC';
		else $forma = 'DESC';
		$data['o'] = empty($_GET['o']) ? 'fecha' : $_GET['o'];
		$data['f'] = empty($_GET['f']) ? 'd' : $_GET['f'];
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(a.file_id) FROM a_files AS a LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE a.f_user = '.$userid.$where.' AND a.f_folder = \''.$folderid.'\' ORDER BY '.$order.' '.$forma.'');
		list ($total) = db_exec('fetch_row', $query);
		// ESTAN EN FOLDER Y ES PUBLICO?
		if($folderid > 0) {
			$folder = db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', "SELECT folder_priv FROM a_folder_files WHERE folder_id = ". $folderid));
		}
		// PAGINAR
		$max = 20; // MAXIMO A MOSTRAR
		$limit =$tsCore->setPageLimit($max,false,$total);
		$data['pages'] = $tsCore->getPagination($total, $max);		
		// HAY ARCHIVOS?
		if($total > 0 || $userid == $tsUser->uid || !empty($tsUser->is_admod) || $folder['folder_priv'] == 0) {
			// MOSTRAR ARCHIVOS		
			$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.*, u.user_id, u.user_name FROM a_files AS a LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE a.f_user = '.$userid . $where.' AND a.f_folder =  \''.$folderid.'\' ORDER BY '.$order.' '.$forma.' LIMIT '.$limit);
			$data['data'] = result_array($query);
			$data['total'] = $total;
			// DATOS DEL AUTOR (?
			$data['user_name'] = $tsUser->getUserName($userid);
			$data['user_id'] = $userid;
			// SI SOY YO, QUE MUESTRE MIS FAVORITOS :NOFA:
			if($userid == $tsUser->uid) {
				$q = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.file_id, a.f_estado, a.f_nombre, a.f_user, a.f_ext, u.user_name FROM a_favoritos AS f LEFT JOIN a_files AS a ON a.file_id = f.fav_file LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE f.fav_user = '.$userid.$where.' ORDER BY f.fav_fecha DESC LIMIT 5');
				$data['favoritos'] = result_array($q);
				// TOTAL FAVORITOS
				$q2 = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(fav_id) FROM a_favoritos WHERE fav_user = \''.$tsUser->uid.'\''));
				$data['total_favs'] = $q2[0];
			}
			return $data;				
		} else return 'El usuario no ha subido archivos o no son p&uacute;blicos.';
	}
	/*
      ULTIMOS ARCHIVOS SUBIDOS [PUBLICOS]
   */
   function getLastFiles(){
		global $tsCore, $tsUser;
		//
		$max = 6; // MAXIMO A MOSTRAR
		// PAGINAS
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(a.file_id) FROM a_files AS a LEFT JOIN u_miembros AS u ON u.user_id = a.f_user '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'WHERE a.f_estado = \'1\' AND u.user_activo = \'1\' && u.user_baneado = \'0\''));
		list ($total) = db_exec('fetch_row', $query);
		$start = $tsCore->setPageLimit($max, false, $total);
		$data['pages'] = $tsCore->getPages($total, $max);
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.file_id, a.f_nombre, a.f_ext, a.f_fecha, a.f_peso, a.f_comentarios, a.f_estado, u.user_name, u.user_activo, u.user_baneado FROM a_files AS a LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE a.f_user != \''.$tsUser->uid.'\' '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'AND a.f_estado = \'1\' AND u.user_activo = \'1\' && u.user_baneado = \'0\'').' ORDER BY a.file_id DESC LIMIT '.$start);
		$data['data'] = result_array($query);
		//
		return $data;
   }
	/*
		DESCARGAR ARCHIVO
	*/
	function descargaFile() {
		global $tsCore, $tsUser;
		$fileid = $tsCore->setSecure($_POST['fileid']);		
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_user, f_descargas, f_url, f_ext FROM a_files WHERE file_id = \''.(int)$fileid.'\'');		
		$data = db_exec('fetch_assoc', $query);
		//
		if(!empty($data['file_id'])) {
			//			
			if($this->userDescarga($fileid, $data['f_user'], $data['f_descargas']+1)) return '1: Descarga exitosa';
			else return '0: Ocurri&oacute; un error al intentar procesar lo solicitado.';
		} else return '0: El archivo no existe.';
	}
	
	/*
		USUARIO QUE DESCARGA
	*/
	function userDescarga($fileid = NULL, $userid = NULL, $total = NULL) {
		global $tsUser;
		// SI ES SU PROPIO ARCHIVO QUE NO CUENTE LA DESCARGA
		if($tsUser->uid != $userid) {		
			$q = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(descarga_id) FROM a_descargas WHERE d_user = '.$tsUser->uid.' AND d_file = '.$fileid));
			if ($q[0] == 0 && $tsUser->is_member) {
				$_SERVER['REMOTE_ADDR'] = $_SERVER['X_FORWARDED_FOR'] ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
				if(!filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) { die('0: Su ip no se pudo validar.'); }
				db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO `a_descargas` (d_file, d_user, d_autor, d_total, d_fecha, d_ip) VALUES (\''.$fileid.'\', \''.$tsUser->uid.'\', \''.$userid.'\', \'1\', \''.time().'\', \''.$_SERVER['REMOTE_ADDR'].'\')');			
			} else {
				$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT d_user, d_file, d_total FROM a_descargas WHERE d_autor = '.$userid.' AND d_file = '.$fileid);
				$data = db_exec('fetch_assoc', $query);
				// SI YA DESCARGO ANTES, SE SUMA UNA MAS EN SU HISTORIAL
				db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_descargas SET d_total = '.$data['d_total'].'+1, d_fecha = '.time().' WHERE d_user = '.$tsUser->uid.' AND d_file = \''.(int)$fileid.'\'');	
			}
			// SUMA LA NUEVA DESCARGA AL ARCHIVO
			db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_descargas = '.$total.' WHERE file_id = \''.(int)$fileid.'\'');
		}
		
		return true;
	}
	
	/*
		AGREGAR A FAVORITOS
	*/
	function favoritFile() {
		global $tsCore, $tsUser, $tsMonitor, $tsActividad;
		$fileid = $tsCore->setSecure($_POST['fileid']);
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_user, f_nombre, f_descargas, f_url, f_ext FROM a_files WHERE file_id = \''.(int)$fileid.'\'');		
		$data = db_exec('fetch_assoc', $query);
		//
		if(!empty($data['file_id'])) {
			if($data['f_user'] != $tsUser->uid) {
				$q = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(fav_id) FROM a_favoritos WHERE fav_file = \''.(int)$fileid.'\' AND fav_user ='.$tsUser->uid));
				if($q[0] == 0) {
					if(db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO `a_favoritos` (fav_file, fav_user, fav_fecha) VALUES (\''.$fileid.'\', \''.$tsUser->uid.'\', \''.time().'\')')) {
						return '1: <b>'.$data['f_nombre'].'.'.$data['f_ext'].'</b> a&ntilde;adido a tus favoritos correctamente.';
						$tsMonitor->setFollowNotificacion(20, 2, $tsUser->uid, $fileid);
		            // REGISTRAR MI ACTIVIDAD
		            $tsActividad->setActividad(13, $fileid);
					} else return '0: Ocurri&oacute; un error al intentar procesar lo solicitado.';
				} else return '0: Ya has agregado este archivo a favoritos.';
			} else return '0: No puedes agregar tu propio archivo a favoritos.';
		} else return '0: El archivo no existe.';
	}
	
	/* 
		BORRAR FAVORITOS [SOLO EL AUTOR]
	*/
	function delfavFile(){
		global $tsCore, $tsUser;
		//
		$favid = $tsCore->setSecure($_POST['favid']);
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT fav_id, fav_user FROM a_favoritos WHERE fav_id = \''.(int)$favid.'\' AND fav_user = \''.$tsUser->uid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// ES MIO O TIENE PERMISOS
		if(!empty($data['fav_id'])){
			if($data['fav_user'] == $tsUser->uid) {
				if(db_exec(array(__FILE__, __LINE__), 'query', 'DELETE FROM a_favoritos WHERE fav_id = \''.(int)$favid.'\'')) {
					return '1: Favorito removido con exito.';
				} else return '0: Ocurri&oacute; un error al intentar procesar lo solicitado.';
			} else return '0: Lo que intentas hacer no est&aacute; permitido.';
		} else return '0: El favorito no existe o ya lo eliminaste.';
	}
	
	/*
		FAVORITOS DEL AUTOR
	*/
	function favFiles() {
		global $tsCore, $tsUser;		
		// EXISTE EL USUARIO?
		if ($tsUser->uid > 0) {
			// PUEDO VER TODOS LOS ARHIVOS?
			if($tsUser->is_admod) {
				if($tsCore->settings['c_see_mod'] == 1) {
					$where = '';
				} else $where = ' AND u.user_activo = \'1\' && u.user_baneado = \'0\' AND a.f_estado = \'1\'';
			} else {
				$where = ' AND a.f_estado = \'1\' AND a.f_privado = \'0\'';
			}
			$q = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(f.fav_id) FROM a_favoritos AS f LEFT JOIN a_files AS a ON file_id = fav_file LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE f.fav_user = '.$tsUser->uid.$where);
			list ($total) = db_exec('fetch_row', $q);
			//		
			$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.*, f.*, u.user_id, u.user_name FROM a_favoritos AS f LEFT JOIN a_files AS a ON file_id = fav_file LEFT JOIN u_miembros AS u ON u.user_id = a.f_user WHERE f.fav_user = '.$tsUser->uid.$where.' ORDER BY f.fav_fecha DESC');
			$data['data'] = result_array($query);
			$data['total'] = db_exec('num_rows', $query);
			//			
			return $data;
		} else return 'Debes registrarte para guardar archivos en favoritos.';
	}
	/*
		ULTIMOS COMENTARIOS
	*/
	function getLastcom() {
		global $tsCore, $tsUser;
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.com_user, a.com_fecha, f.file_id, f.f_nombre, f.f_estado, f.f_ext, u.user_name FROM a_comentarios AS a LEFT JOIN a_files AS f ON a.com_file = f.file_id LEFT JOIN u_miembros AS u ON u.user_id = a.com_user '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'AND f.f_estado = \'1\' AND u.user_activo = \'1\' && u.user_baneado = \'0\'').' ORDER BY a.com_fecha DESC LIMIT 10');
		$data = result_array($query);
		//
		return $data;
	}
	
	/*
		VER COMENTARIOS DEL ARCHIVO
	*/
	function getComentarios() {
		global $tsCore, $tsUser;
		$fileid = $tsCore->setSecure($_GET['fileid']);
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT a.*, f.f_estado, u.user_name FROM a_comentarios AS a LEFT JOIN a_files AS f ON a.com_file = f.file_id LEFT JOIN u_miembros AS u ON u.user_id = a.com_user WHERE a.com_file = \''.(int)$fileid.'\' '.($tsUser->is_admod && $tsCore->settings['c_see_mod'] == 1 ? '' : 'AND f.f_estado = \'1\' AND u.user_activo = \'1\' && u.user_baneado = \'0\'').' ORDER BY a.com_fecha ASC');
		$data['total'] = db_exec('num_rows', $query);
		
		$com = result_array($query);
		$i = 0;
		foreach($com as $cm){
			$data['com'][$i] = $cm;
			$data['com'][$i]['com_body_source'] = $cm['com_body'];
			$data['com'][$i]['com_body'] = $tsCore->parseBadWords($tsCore->parseBBCode($cm['com_body'], 'files'), true);
			$i++;
		}
		//
		return $data;
	}
	
	/*
		AGREGAR NUEVO COMENTARIO
	*/
	function newcomFile() {
		global $tsCore, $tsUser, $tsMonitor, $tsActividad;
		// OBTENEMOS DATOS
		$fileid = $tsCore->setSecure($_POST['fileid']);
		$body = substr($_POST['body'],0,1500);
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_privado, f_estado, f_comentarios, f_user FROM a_files WHERE file_id = \''.(int)$fileid.'\' LIMIT 1');
		$data = db_exec('fetch_assoc', $query);
		// EXISTE EL ARCHIVO?
		if(!empty($data['file_id'])) {
			// ESTA DESABILITADO?
			if($data['f_estado'] != 0 || $tsUser->is_admod) {
				// ES PRIVADO?
				if($data['f_privado'] != 1 || $data['f_user'] == $tsUser->uid || $tsUser->is_admod) {
					// ANTI FLOOD
					$tsCore->antiFlood();
					$_SERVER['REMOTE_ADDR'] = $_SERVER['X_FORWARDED_FOR'] ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
					if(!filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) { die('0: Su ip no se pudo validar.'); }
						if(db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO `a_comentarios` (`com_file`, `com_user`, `com_body`, `com_fecha`, `com_ip`) VALUES (\''.(int)$fileid.'\', \''.$tsUser->uid.'\', \''.$body.'\', \''.time().'\', \''.$_SERVER['REMOTE_ADDR'].'\')')) {
							$cid = db_exec('insert_id');	
							// SUMAMOS ESTADISTICAS :D
							db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_comentarios = '.$data['f_comentarios'].'+1 WHERE file_id = \''.(int)$fileid.'\'');
							// NOTIFICAR SI FUE CITADO Y AL AUTOR DEL ARCHIVO
                    	$this->quoteNoti($fileid, $data['f_user'], $cid, $body);
               		$tsMonitor->setFollowNotificacion(18, 1, $tsUser->uid, $fileid);
		               // REGISTRAR MI ACTIVIDAD
		               $tsActividad->setActividad(12, $fileid);
							// PARSEAMOS BBCODE
							$body = $tsCore->parseBadWords($tsCore->parseBBCode($body, 'files'), true);
							return array($body, $tsUser->uid, $tsUser->nick, time(), (int)$cid, $fileid);
						} else return '0: Ocurri&oacute; un error al al agregar el comentario, intentalo m&aacute;s tarde.';
				} else return '0: El archivo es privado y no puedes comentarlo.';
			} else return '0: El archivo est&aacute; en revisi&oacute;n y no puedes comentarlo.';
		} else return '0: El archivo no existe o ha sido eliminado.';
	}
	
	/*
		RESPUESTA A COMENTARIO?
	*/
	function quoteNoti($fileid = NULL, $file_user = NULL, $cid = NULL, $comentario = NULL){
      global $tsCore, $tsUser, $tsMonitor;
      $ids = array();
      $total = 0;
      //
      preg_match_all('/\B@([a-zA-Z0-9_-]{4,16}+)\b/', $comentario, $users);
      //
      if(!empty($users[1])) {
         foreach($users[1] as $user){
            # DATOS
            $udata = explode('|',$user);
              	if(!is_array($udata)) {
                  $user = $user;   
                  $lcid = $cid;
               } else {
                  $user = $udata[0];
                  $lcid = (int) $udata[1];
               }
               # COMPROBAR
               if($user != $tsUser->nick){
                  $uid = $tsUser->getUserID($tsCore->setSecure($user));
                  if(!empty($uid) && $uid != $tsUser->uid && !in_array($uid, $ids)){
                     $ids[] = $uid;
                     $tsMonitor->setNotificacion(19, $uid, $tsUser->uid, $fileid, $lcid);
                  }
                  ++$total;
              	}
            }
			// MANDAMOS NOTIFICACION AL AUTOR
			//$tsMonitor->setNotificacion(19, $file_user, $tsUser->uid, $fileid, $cid);
      }		
		return true;
	}
	
	/* 
		BORRAR COMENTARIOS
	*/
	function delcomFile(){
		global $tsCore, $tsUser;
		//
		$comid = $tsCore->setSecure($_POST['comid']);
		$fileid = $tsCore->setSecure($_POST['fileid']);
		// CONSULTAR
		$q = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT com_id, com_user FROM a_comentarios WHERE com_id = \''.(int)$comid.'\'');
		$dato = db_exec('fetch_assoc', $q);
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_comentarios, f_estado, f_user FROM a_files WHERE file_id = \''.(int)$fileid.'\' LIMIT 1');
		$data = db_exec('fetch_assoc', $query);
		// EXISTE EL ARCHIVO?
		if(!empty($data['file_id'])) {
			// ESTA DESABILITADO?
			if($data['f_estado'] != 0) {
				// EXISTE EL COMENTARIO?
				if(!empty($dato['com_id'])){
					// ES MIO O TIENE PERMISOS
					if($dato['com_user'] == $tsUser->uid || !empty($tsUser->is_admod)) {
						if(db_exec(array(__FILE__, __LINE__), 'query', 'DELETE FROM a_comentarios WHERE com_id = \''.(int)$comid.'\'')) {
							// DESCONTAMOS EL COMENTARIO DE LAS ESTADISTICAS DEL ARCHIVO
							db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_comentarios = '.$data['f_comentarios'].'-1 WHERE file_id = \''.(int)$fileid.'\'');
							return '1: Comentario Eliminado Exitosamente.';
						} else return '0: Ocurri&oacute; un error al intentar procesar lo solicitado.';
					} else return '0: Lo que intentas hacer no est&aacute; permitido.';
				} else return '0: El comentario no existe.';
			} else return '0: El archivo est&aacute; en revisi&oacute;n, hasta entonces no podras borrar el comentario.';
		} else return '0: El archivo no existe o fue eliminado.';
	}
	/* 
		MOSTRAR CARPETAS
	*/
	function folderUser($folderid = NULL, $userid = NULL){
		global $tsUser;
		//
		if(empty($folderid)) {
			// SON MIS CARPETAS?
			if($userid != $tsUser->uid) $and = 'AND folder_priv = \'0\'';
			else $and = '';
			//
			$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT * FROM a_folder_files WHERE folder_user = \''.(int)$userid.'\' '.$and.'');
			$data['data'] = result_array($query);
			$data['total'] = db_exec('num_rows', $query);
			$data['fid'] = 0;
			//
			return $data;
		} else {
			$dato = db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT folder_name, folder_id FROM a_folder_files WHERE folder_id = \''.$folderid.'\''));
			$data['data'] = false;
			// NOMBRE DE LA CARPETA
			$data['nombre'] = '> '.$dato['folder_name'];
			$data['fid'] = $dato['folder_id'];
			return $data;
		}
	}
	
	/* 
		CREAR CARPETA
	*/
	function newFolder(){
		global $tsCore, $tsUser;
		//
		$name = $_POST['nombre'];
		if(!empty($name)){
			if(!empty($tsUser->uid)) {			
				if(db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO `a_folder_files` (folder_name, folder_user, folder_seo, folder_fecha, folder_priv) VALUES (\''.$name.'\', \''.$tsUser->uid.'\', \''.$tsCore->setSEO($name).'\', \''.time().'\', \'1\')')) {
					return array($name, db_exec('insert_id'));
				} else return '0: Hubo un error al intentar procesar lo solicitado.';					
			} else return '0: Lo que intentas hacer no est&aacute; permitido.';
		} else return '0: Debes escribir un nombre primero.';
	}
	
	/* 
		EDITAR NOMBRE CARPETA
	*/
	function editFolder(){
		global $tsCore, $tsUser;
		//
		$folderid = $tsCore->setSecure($_POST['folderid']);
		$name = $_POST['nombre'];
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT folder_id, folder_user FROM a_folder_files WHERE folder_id = \''.$folderid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// NOMBRE VACIO?
		if(!empty($name)) {
			// ES MIO?
			if(!empty($data['folder_id'])){
				if($data['folder_user'] == $tsUser->uid) {			
					if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_folder_files SET folder_name = \''.$name.'\' WHERE folder_id = \''.(int)$folderid.'\'')) {
						return '1: Cambio de nombre exitoso.';
					} else return '0: Hubo un error al intentar procesar lo solicitado.';					
				} else return '0: Lo que intentas hacer no est&aacute; permitido.';
			} else return '0: La carpeta no existe.';
		} else return '0: Escribe un nombre primero.';
	}
	
	/*
		CAMBIAR PRIVACIDAD FOLDER
	*/
	function privFolder() {
		global $tsCore, $tsUser;
		//
		$folderid = $tsCore->setSecure($_POST['folderid']);
		$privado = $tsCore->setSecure($_POST['privado']);		
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT folder_id, folder_user FROM a_folder_files WHERE folder_id = \''.$folderid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// EXISTE?
		if(!empty($data['folder_id'])){
			// ES MIO?
			if($data['folder_user'] == $tsUser->uid) {
				if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_folder_files SET folder_priv = '.(int)$privado.' WHERE folder_id = '.(int)$folderid)) {
				db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_privado = '.(int)$privado.' WHERE f_folder = '.(int)$folderid);
					return '1: Cambio de privacidad exitoso.';
				} else return '0: Hubo un error al intentar procesar lo solicitado.';		
			} else return '0: Lo que intentas hacer no est&aacute; permitido.';
		} else return '0: La carpeta no existe.';
	}
	
	/* 
		BORRAR FOLDER
	*/
	function delFolder(){
		global $tsCore, $tsUser;
		//
		$folderid = $tsCore->setSecure($_POST['folderid']);
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT folder_id, folder_user FROM a_folder_files WHERE folder_id = \''.(int)$folderid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// EXISTE?
		if(!empty($data['folder_id'])){
			// ES MIO?
			if($data['folder_user'] == $tsUser->uid) {
				// DEVOLVEMOS LOS ARCHIVOS A LA RAIZ
				db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_folder =  \'0\' WHERE f_folder = '.(int)$folderid);
				// BORRAR CARPETA DE LA BD
				db_exec(array(__FILE__, __LINE__), 'query', 'DELETE FROM a_folder_files WHERE folder_id = \''.(int)$folderid.'\'');
				//
				return '1: Carpeta eliminada.';
			} else return '0: Lo que intentas hacer no est&aacute; permitido.';
		} else return '0: La carpeta no existe.';
	}
	
	/*
		VER CARPETAS
	*/
    function verFolders() {
		global $tsUser;
      $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT folder_id, folder_name FROM a_folder_files WHERE folder_user = '.(int)$tsUser->uid.'');
      $data = result_array($query);     
		$data['total'] = safe_count($data['data']);

      //
      if(empty($data)) return array('folders' => 0, 'data' => 'No has creado carpetas a&uacute;n.');
      else return array('folders' => 1, 'data' => $data);
   }
	
	/*
		MOVER ARCHIVO A CARPETA
	*/
	function moverFile() {
		global $tsUser;
		//
		$folderid = intval($_POST['folderid']);
		$fileid = intval($_POST['fileid']);		
		// CONSULTAR
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_user, f_folder FROM a_files WHERE file_id = \''.(int)$fileid.'\'');
		$data = db_exec('fetch_assoc', $query);
		// EXISTE?
		if(!empty($data['file_id'])){
			if(!$data['f_folder'] == $folderid) {
				if($data['f_user'] == $tsUser->uid) {
					if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_folder = '.(int)$folderid.' WHERE file_id = '.(int)$fileid))
						return '1: Movimiento exitoso.';
					else return '0: Hubo un error al intentar procesar lo solicitado.';		
				} else return '0: Lo que intentas hacer no est&aacute; permitido.';
			} else return '0: No puedes mover el archivo al mismo lugar.';
		} else return '0: El archivo no existe.';
	}
	/* 
		MOVER ARCHIVOS SELECCIONADOS
	*/
	function moverFiles(){
		global $tsUser, $tsMonitor;
		$folderid = intval($_POST['folderid']);
		$elmts = split(',', $_POST['files']);
		if(count($elmts) == 0) return '0: Seleccione un archivo por lo menos.';
		$files = 0;
		foreach($elmts as $file) {
			// CONSULTAR
			$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT file_id, f_user, f_folder FROM a_files WHERE file_id = \''.(int)$file.'\'');
			$data = db_exec('fetch_assoc', $query);
			// EXISTE?
			if(!empty($data['file_id'])){
				if($data['f_folder'] != $folderid) {
					if($data['f_user'] == $tsUser->uid) {
						if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE a_files SET f_folder = '.(int)$folderid.' WHERE file_id = '.(int)$file)) {
							$files++;
						}
					}
				}
			}
		}
		if($files == 0) return '0: No se movio ningun archivo, intente de nuevo.';
		else return '1: Se han movido <b>'.$files.'</b> archivos correctamente.';
	}
	
	/*
		BUSCAR ARCHIVOS
	*/
	function searchFile() {
		global $tsUser, $tsCore;
		//
		$userid = intval($_POST['userid']);
		$folderid = intval($_POST['folderid']);
		$data['text'] = $tsCore->setSecure($_POST['text']);
		//
		if(strlen($data['text']) >= 3) {
			$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT f.*, u.user_name FROM a_files AS f LEFT JOIN u_miembros AS u ON f.f_user = u.user_id WHERE f.f_user = \''.(int)$userid.'\' AND f.f_folder = \''.(int)$folderid.'\' AND f.f_nombre LIKE \'%'.$data['text'].'%\' '.($tsUser->uid == $userid ? '' : 'AND f.f_privado = \'0\'').' OR f.f_user = \''.(int)$userid.'\' AND f.f_folder = \''.(int)$folderid.'\' AND f.f_ext LIKE \'%'.$data['text'].'%\' ORDER BY f.f_fecha DESC');
			$data['data'] = result_array($query);
			$data['total'] = safe_count($data['data']);
			//
			return $data;
		}
	}

	/*
		Función para extraer información del audio
	*/
	function getMp3Info($archivo = NULL, $default = true) {
		global $tsCore;
		include TS_LIBS.'Mp3Info.php';

		$ruta_archivo = TS_FILES. 'archivos/';
		$audio = new Mp3Info($ruta_archivo . $archivo, $default );
		$informacion = array(
			$audio->tags2['TIT2'], 
			$tsCore->convertirms($audio->duration), 
			$audio->bitRate/1000, 
			$audio->channel
		);
		return $informacion;
	}
	/*
		Función para extraer contenido de un archivo
	*/
	function getTxtPhp($archivo = NULL, $tipo = 'r') {

		$ruta_archivo = TS_FILES. 'archivos/';
		$archivo = $ruta_archivo . $archivo;
		$aCadena = file($archivo);
    	return $aCadena;

	}
    
}