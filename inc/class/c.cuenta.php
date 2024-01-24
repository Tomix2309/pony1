<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Modelo para el control y edición de la cuenta de usuario
 *
 * @name    c.cuenta.php
 * @author  PHPost Team
 */
require_once TS_EXTRA . "datos.php";
class tsCuenta {

   /**
    * @name loadPerfil()
    * @access public
    * @uses Cargamos el perfil de un usuario
    * @param int
    * @return array
    */
	public function loadPerfil($user_id = 0){
		global $tsUser, $tsCore;
		//
		if(empty($user_id)) $user_id = $tsUser->uid;
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT p.*, u.user_avatar, u.user_socials, u.user_registro, u.user_lastactive FROM u_perfil AS p LEFT JOIN u_miembros AS u ON p.user_id = u.user_id WHERE p.user_id = \''.(int)$user_id.'\' LIMIT 1');
		$perfilInfo = db_exec('fetch_assoc', $query);
		// Redes viculadas
		$perfilInfo['socials'] = json_decode($perfilInfo['user_socials'], true);
		// Obtenemos el avatar del usuario
		$perfilInfo['avatar'] = $tsCore->getAvatar($perfilInfo['user_id']);
		// CAMBIOS
      $perfilInfo = $this->unData($perfilInfo);
		//
		return $perfilInfo;
	}
    /*
        loadExtras()
    */
    private function unData($data){
    	global $redes;
      //
      $d = ['p_gustos', 'p_tengo', 'p_idiomas', 'p_configs'];
      foreach ($d as $v) $data[$v] = unserialize($data[$v]);
		// Redes sociales
      $data["redes"] = $redes;
		$data['p_socials'] = (array)json_decode($data['p_socials'], true);
      //
      return $data;
    }
	/*
		loadHeadInfo($user_id)
	*/
	function loadHeadInfo(int $user_id = 0){
		global $tsUser, $tsCore;
		// INFORMACION GENERAL
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT u.user_id, u.user_name, u.user_registro, u.user_lastactive, u.user_activo, u.user_baneado, p.user_sexo, p.user_pais, p.p_nombre, p.p_avatar, p.p_mensaje, p.p_socials, p.p_configs FROM u_miembros AS u, u_perfil AS p WHERE u.user_id = \''.(int)$user_id.'\' AND p.user_id = \''.(int)$user_id.'\'');
		$data = db_exec('fetch_assoc', $query);
        
      $data['user_avatar'] = $tsCore->getAvatar($user_id);
        //
      $data['p_nombre'] = $tsCore->setSecure($tsCore->parseBadWords($data['p_nombre']), true);
      $data['p_mensaje'] = $tsCore->parseBBCode($tsCore->setSecure($tsCore->parseBadWords($data['p_mensaje']), true));
      // Redes Sociales
		if(!empty($data['p_socials'])) {
			$data['p_socials'] = json_decode($data['p_socials'], true);
			foreach ($this->redes as $name => $valor) $data['p_socials'][$name];
   	} else $data['p_socials'] = '';
		$data['p_configs'] = unserialize($data['p_configs']);
		// pais
		$data['pais']= [
			'icon'=> strtolower($data['user_pais']),
			'name'=> $tsPaises[$data['user_pais']]
		];

		if($data['p_configs']['hits'] == 0){
			$data['can_hits'] = false;
		}elseif($data['p_configs']['hits'] == 3 && ($this->iFollow($user_id) || $tsUser->is_admod)){
			$data['can_hits'] = true;
		}elseif($data['p_configs']['hits'] == 4 && ($this->yFollow($user_id) || $tsUser->is_admod)){
			$data['can_hits'] = true;
		}elseif($data['p_configs']['hits'] == 5 && $tsUser->is_member){
			$data['can_hits'] = true;
		}elseif($data['p_configs']['hits'] == 6){
			$data['can_hits'] = true;
		}
		
		if($data['can_hits']){
		$data['visitas'] = result_array(db_exec(array(__FILE__, __LINE__), 'query', 'SELECT v.*, u.user_id, u.user_name FROM w_visitas AS v LEFT JOIN u_miembros AS u ON v.user = u.user_id WHERE v.for = \''.(int)$user_id.'\' && v.type = \'1\' && user > 0 ORDER BY v.date DESC LIMIT 7'));
		$q1 = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(u.user_id) AS a FROM w_visitas AS v LEFT JOIN u_miembros AS u ON v.user = u.user_id WHERE v.for = \''.(int)$user_id.'\' && v.type = \'1\''));
		$data['visitas_total'] = $q1[0];
        }
		

		$visitado = db_exec('num_rows', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT id FROM `w_visitas` WHERE `for` = \''.(int)$user_id.'\' && `type` = \'1\' && '.($tsUser->is_member ? '(`user` = \''.$tsUser->uid.'\' OR `ip` LIKE \''.$_SERVER['REMOTE_ADDR'].'\')' : '`ip` LIKE \''.$_SERVER['REMOTE_ADDR'].'\'').' LIMIT 1'));
		if(($tsUser->is_member && $visitado == 0 && $tsUser->uid != $user_id) || ($tsCore->settings['c_hits_guest'] == 1 && !$tsUser->is_member && !$visitado)) {
			db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO w_visitas (`user`, `for`, `type`, `date`, `ip`) VALUES (\''.$tsUser->uid.'\', \''.(int)$user_id.'\', \'1\', \''.time().'\', \''.$_SERVER['REMOTE_ADDR'].'\')');
		}else db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE `w_visitas` SET `date` = \''.time().'\', ip = \''.$_SERVER['REMOTE_ADDR'].'\' WHERE `for` = \''.(int)$post_id.'\' && `type` = \'1\'');
		
		// REAL STATS
		$data['stats'] = db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT u.user_id, u.user_rango, u.user_puntos, u.user_posts, u.user_comentarios, u.user_seguidores, u.user_cache, r.r_name, r.r_color FROM u_miembros AS u LEFT JOIN u_rangos AS r ON  u.user_rango = r.rango_id WHERE u.user_id = \''.(int)$user_id.'\''));
		
      if($data['stats']['user_cache'] < time()-($tsCore->settings['c_stats_cache']*60)) {
      	# TOTAL POSTS
      	$q1 = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(post_id) AS p FROM p_posts WHERE post_user = \''.(int)$user_id.'\' && post_status = \'0\''));
      	$data['stats']['user_posts'] = $q1[0];
      	# TOTAL SEGUIDORES
        	$q2 = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(follow_id) AS s FROM u_follows WHERE f_id =\''.(int)$user_id.'\' && f_type = \'1\''));
        	$data['stats']['user_seguidores'] = $q2[0];
      	# TOTAL COMENTARIOS
        	$q3 = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(cid) AS c FROM p_comentarios WHERE c_user = \''.(int)$user_id.'\' && c_status = \'0\''));
        	$data['stats']['user_comentarios'] = $q3[0];
        	#
        	db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE u_miembros SET user_posts = \''.$q1[0].'\', user_comentarios = \''.$q3[0].'\', user_seguidores = \''.$q2[0].'\', user_cache = \''.time().'\' WHERE  user_id = \''.(int)$user_id.'\'');
      }
      # TOTAL FOTOS
      $q4 = db_exec('fetch_row', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(foto_id) AS f FROM f_fotos WHERE f_user = \''.(int)$user_id.'\' && f_status = \'0\''));
      $data['stats']['user_fotos'] = $q4[0];
		
		// BLOQUEADO
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT * FROM `u_bloqueos` WHERE b_user = \''.$tsUser->uid.'\' AND b_auser = \''.(int)$user_id.'\' LIMIT 1');
        $data['block'] = db_exec('fetch_assoc', $query);
        
        //
		return $data;
	}
	/*
		loadGeneral($user_id)
	*/
	function loadGeneral($user_id){
		global $tsCore;
		# SIGNO
		$query = db_exec(array(__FILE__, __LINE__), 'query', "SELECT user_dia, user_mes FROM u_perfil WHERE user_id = {$user_id}");
		$data['signos'] = db_exec('fetch_assoc', $query);
		$dia = $data['signos']['user_dia'];
		$mes = $data['signos']['user_mes'];

		if((($dia >= "21") && ($mes == "3")) or (($dia <= "20") && ($mes == "4"))) 
			$data['signo'] = array("signo_name" => "Aries", "code" => "&#9800");
		if((($dia >= "21") && ($mes == "4")) or (($dia <= "20") && ($mes == "5"))) 
			$data['signo'] = array("signo_name" => "Tauro", "code" => "&#9801");
		if((($dia >= "21") && ($mes == "5")) or (($dia <= "21") && ($mes == "6"))) 
			$data['signo'] = array("signo_name" => "Geminis", "code" => "&#9802");
		if((($dia >= "22") && ($mes == "6")) or (($dia <= "22") && ($mes == "7"))) 
			$data['signo'] = array("signo_name" => "Cancer", "code" => "&#9803");
		if((($dia >= "23") && ($mes == "7")) or (($dia <= "22") && ($mes == "8"))) 
			$data['signo'] = array("signo_name" => "Leo", "code" => "&#9804");
		if((($dia >= "23") && ($mes == "8")) or (($dia <= "22") && ($mes == "9"))) 
			$data['signo'] = array("signo_name" => "Virgo", "code" => "&#9805");
		if((($dia >= "23") && ($mes == "9")) or (($dia <= "22") && ($mes == "10"))) 	
			$data['signo'] = array("signo_name" => "Libra", "code" => "&#9806");
		if((($dia >= "23") && ($mes == "10")) or (($dia <= "21") && ($mes == "11"))) 	
			$data['signo'] = array("signo_name" => "Escorpio", "code" => "&#9807");
		if((($dia >= "22") && ($mes == "11")) or (($dia <= "21") && ($mes == "12"))) 	
			$data['signo'] = array("signo_name" => "Sagitario", "code" => "&#9808");
		if((($dia >= "22") && ($mes == "12")) or (($dia <= "19") && ($mes == "1"))) 	
			$data['signo'] = array("signo_name" => "Capricornio", "code" => "&#9809");
		if((($dia >= "20") && ($mes == "1")) or (($dia <= "18") && ($mes == "2"))) 
			$data['signo'] = array("signo_name" => "Acuario", "code" => "&#9810");
		if((($dia >= "19") && ($mes == "2")) or (($dia <= "20") && ($mes == "3"))) 
			$data['signo'] = array("signo_name" => "Piscis", "code" => "&#9811");

		// MEDALLAS
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT m.*, a.* FROM w_medallas AS m LEFT JOIN w_medallas_assign AS a ON a.medal_id = m.medal_id WHERE a.medal_for = \''.(int)$user_id.'\' AND m.m_type = \'1\' ORDER BY a.medal_date DESC LIMIT 21');
		$data['medallas'] = result_array($query);
      $data['m_total'] = safe_count($data['medallas']);
        
		// SEGUIDORES
      $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT f.follow_id, u.user_id, u.user_name FROM u_follows AS f LEFT JOIN u_miembros AS u ON f.f_user = u.user_id WHERE f.f_id = \''.(int)$user_id.'\' && f.f_type = \'1\' && u.user_activo = \'1\' && u.user_baneado = \'0\' ORDER BY f.f_date DESC LIMIT 6');
      $data['segs']['data'] = result_array($query);
      $data['segs']['total'] = safe_count($data['segs']['data']);
        
		// SIGUIENDO
      $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT f.follow_id, u.user_id, u.user_name FROM u_follows AS f LEFT JOIN u_miembros AS u ON f.f_id = u.user_id WHERE f.f_user = \''.(int)$user_id.'\' AND f.f_type = \'1\' && u.user_activo = \'1\' && u.user_baneado = \'0\' ORDER BY f.f_date DESC LIMIT 6');
      $data['sigd']['data'] = result_array($query);
      $data['sigd']['total'] = safe_count($data['sigd']['data']);
      // ULTIMAS FOTOS
      if(empty($_GET['pid'])){
		  	$data['fotos'] = result_array(db_exec([__FILE__, __LINE__], 'query', "SELECT foto_id, f_title, f_url FROM f_fotos WHERE f_user = $user_id ORDER BY foto_id DESC LIMIT 6"));
			$data['fotos_total'] = safe_count($data['fotos']);
      }
      //
		return $data;
	}
    /*
        iFollow()
    */
    function iFollow($user_id){
        global $tsUser;
        // SEGUIR
        $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT follow_id FROM u_follows WHERE f_id = \''.(int)$user_id.'\' AND f_user = \''.(int)$tsUser->uid.'\' AND f_type = \'1\' LIMIT 1');
		$data = db_exec('num_rows', $query);
		
        //
        return ($data > 0) ? true : false;
   }
	
	/*
       yFollow()
    */
    function yFollow($user_id){
        global $tsUser;
        // YO LE SIGO?
        $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT follow_id FROM u_follows WHERE f_id = \''.(int)$tsUser->uid.'\' AND f_user = \''.(int)$user_id.'\' AND f_type = \'1\' LIMIT 1');
		$data = db_exec('num_rows', $query);
		
        //
        return ($data > 0) ? true : false;
    }
    /*
        loadPosts($user_id)
    */
    function loadPosts($user_id){
        global $tsUser;
        //
        $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT p.post_id, p.post_title, p.post_puntos, c.c_seo, c.c_nombre FROM p_posts AS p LEFT JOIN p_categorias AS c ON c.cid = p.post_category WHERE p.post_status = \'0\' AND p.post_user = \''.(int)$user_id.'\' ORDER BY p.post_date DESC LIMIT 18');
        $data['posts'] = result_array($query);
        $data['total'] = safe_count($data['posts']);
        
        // USUARIO
        $data['username'] = $tsUser->getUserName($user_id);
        //
        return $data;
    }
	/*
        loadMedallas($user_id)
    */
    function loadMedallas($user_id){
        //
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT m.*, a.* FROM w_medallas AS m LEFT JOIN w_medallas_assign AS a ON a.medal_id = m.medal_id WHERE a.medal_for = \''.(int)$user_id.'\' AND m.m_type = \'1\' ORDER BY a.medal_date DESC');
		$data['medallas'] = result_array($query);
        $data['total'] = safe_count($data['medallas']);
        
        //
        return $data;
    }
   /**
   	Cambiamos portada desde perfil
   */
   function cambiarPortada($usuario, $portada) {
   	global $tsCore;

   	$IMG = $tsCore->setSecure($tsCore->parseBadWords($portada, true));
		
   	if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE u_perfil SET p_portada = \''.$IMG.'\' WHERE user_id = \''.(int)$usuario.'\'')) return '1: Se cargo portada correctamente.';
   	else '0: Hubo un error, vuelva a intentarlo.';
   }
	/*
		savePerfil()
	*/
	function savePerfil(){
		global $tsCore, $tsUser;
		//
		$save = htmlspecialchars($_POST['pagina']);
		$tab = isset($_POST['tab']) ? htmlspecialchars($_POST['tab']) : '';
		$maxsize = 1000;	// LIMITE DE TEXTO
		// GUARDAR...
		switch($save){
			case '':
            // NUEVOS DATOS
				$perfilData = array(
					'email' => $tsCore->setSecure($_POST['email'], true),
					'pais' => $tsCore->setSecure($_POST['pais']),
					'estado' => $tsCore->setSecure($_POST['estado']),
					'sexo' => ($_POST['sexo'] == 'f') ? 0 : 1,
					'dia' => (int)$_POST['dia'],
					'mes' => (int)$_POST['mes'],
					'ano' => (int)$_POST['ano'],
					'firma' => $tsCore->setSecure($tsCore->parseBadWords($_POST['firma']), true),
				);
            //
            $year = date("Y",time());
            // ANTIGUOS DATOS
				$info = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT user_dia, user_mes, user_ano, user_pais, user_estado, user_sexo, user_firma FROM u_perfil WHERE user_id = {$tsUser->uid} LIMIT 1"));
            //
            $email_ok = $this->isEmail($perfilData['email']);
            // CORRECCIONES
				if(!$email_ok){
					$msg_return = array('field' => 'email', 'error' => 'El formato de email ingresado no es v&aacute;lido.');
					// EL ANTERIOR
					$perfilData['email'] = $tsUser->info['user_email'];
				} elseif(!checkdate($perfilData['mes'],$perfilData['dia'],$perfilData['ano']) || ($perfilData['ano'] > $year || $perfilData['ano'] < ($year - 100))){
					$msg_return = array('error' => 'La fecha de nacimiento no es v&aacute;lida.');
					// LOS ANTERIORES
					$perfilData['mes'] = $info['user_mes'];
					$perfilData['dia'] = $info['user_dia'];
					$perfilData['ano'] = $info['user_ano'];
				} elseif($perfilData['sexo'] > 2){
					$msg_return = array('error' => 'Especifica un g&eacute;nero sexual.');
					$perfilData['sexo'] = $info['user_sexo'];
				} elseif(empty($perfilData['pais'])){
					$msg_return = array('error' => 'Por favor, especifica tu pa&iacute;s.');
					$perfilData['pais'] = $info['user_pais'];
				} elseif(empty($perfilData['estado'])){
					$msg_return = array('error' => 'Por favor, especifica tu estado.'.$_POST['estado']);
					$perfilData['estado'] = $info['user_estado'];
				} elseif(strlen($perfilData['firma']) > 300){
                $msg_return = array('error' => 'La firma no puede superar los 300 caracteres.');
                $perfilData['firma'] = $info['user_firma'];
            } elseif($tsUser->info['user_email'] != $perfilData['email']) {
				   $exists = db_exec('num_rows', db_exec([__FILE__, __LINE__], 'query', "SELECT user_id FROM u_miembros WHERE user_email = '{$perfilData['email']}' LIMIT 1"));
               if($exists) {
                  $msg_return = array('error' => 'Este email ya existe, ingresa uno distinto.');
                  $perfilData['email'] = $tsUser->info['user_email'];
               } else $msg_return = array('error' => 'Los cambios fueron aceptados y ser&aacute;n aplicados en los pr&oacute;ximos minutos. NO OBSTANTE, la nueva direcci&oacute;n de correo electr&oacute;nico especificada debe ser comprobada. '.$tsCore->settings['titulo'].' envi&oacute; un mensaje de correo electr&oacute;nico con las instrucciones necesarias');
				}
			break;
         // NEW PASSWORD
         case 'clave':
            $passwd = $_POST['passwd'];
            $new_passwd = $_POST['new_passwd'];
            $confirm_passwd = $_POST['confirm_passwd'];
            if(empty($new_passwd) || empty($confirm_passwd)) return array('error' => 'Debes ingresar una contrase&ntilde;a.');
            elseif(strlen($new_passwd) < 5) return array('error' => 'Contrase&ntilde;a no v&aacute;lida.');
            elseif($new_passwd != $confirm_passwd) return array('error' => 'Tu nueva contrase&ntilde;a debe ser igual a la confirmaci&oacute;n de la misma.');
            else {
               $key = $tsCore->passwordSL2($tsUser->nick, $passwd);
               if($key != $tsUser->info['user_password']) return array('error' => 'Tu contrase&ntilde;a actual no es correcta.');
               else {
                	$new_key = $tsCore->passwordSL2($tsUser->nick, $new_passwd);
						if(db_exec([__FILE__, __LINE__], 'query', "UPDATE u_miembros SET user_password = '$new_key' WHERE user_id = {$tsUser->uid}")) return true;
               }
            }
         break;
        	// PRIVACIDAD
         case 'privacidad':
				$perfilData['configs'] = serialize([
					'm' => $_POST['muro'], 
					'mf' => (($_POST['muro_firm'] > 4) ? 5 : $_POST['muro_firm']), 
					'rmp' => (($_POST['rec_mps'] > 6) ? 5 : $_POST['rec_mps']), 
					'hits' => (($_POST['last_hits'] == 1 || $_POST['last_hits'] == 2) ? 0 : $_POST['last_hits'])
				]);
         break;
			case 'nick':
				$nuevo_nick = $tsCore->setSecure($_POST['new_nick']);
				// Hay un nick en la lista negra?...
				if(db_exec('num_rows', db_exec([__FILE__, __LINE__], 'query', "SELECT id FROM w_blacklist WHERE type = 4 && value = '$nuevo_nick' LIMIT 1"))) 
           		$message = ['error' => 'Nick no permitido'];           	
           	// El nick esta en uso?
            if(db_exec('num_rows', db_exec([__FILE__, __LINE__], 'query', "SELECT user_id FROM u_miembros WHERE user_name = '$nuevo_nick' LIMIT 1"))) 
            	$message = ['error' => 'Nombre en uso'];
            // Buscamos al usuario, para verificar si ha hecho un cambio
				$data = db_exec("fetch_assoc", db_exec([__FILE__, __LINE__], "query", "SELECT id, user_id, time FROM u_nicks WHERE user_id = {$tsUser->uid} AND estado = 0 LIMIT 1"));
				if($data !== NULL) {
					if(!empty((int)$data['id'])) $message = ['error' => 'Ya tiene una petici&oacute;n de cambio en curso'];
					// Realizamos petición
					elseif(time() - $data['time'] >= 31536000) db_exec([__FILE__, __LINE__], 'query', "UPDATE u_miembros SET user_name_changes = 3 WHERE user_id = {$data['user_id']}");
				}
				// Verificamos la contraseña
				$key = $tsCore->passwordSL2($tsUser->nick, $_POST['password']);
				$message = ['error' => 'Tu contrase&ntilde;a actual no es correcta.'];
				// Verificamos el correo	
				$email_ok = $this->isEmail($_POST['pemail']);
				if(!$email_ok) 
					$message = ['field' => 'email', 'error' => 'El formato de email ingresado no es v&aacute;lido.'];
				$email = empty($_POST['pemail']) ? $tsUser->info['user_email'] : $_POST['pemail'];
				// Si el nick tiene más de 4 y menos de 20 carácteres
				if(strlen($nuevo_nick) < 4 || strlen($nuevo_nick) > 20) 
					$message = ['error' => 'El nick debe tener entre 4 y 20 car&aacute;cteres'];
				// Que no tenga espacios, ni carácteres especiales
				if(!preg_match('/^([A-Za-z0-9]+)$/', $nuevo_nick)) 
					$message = ['error' => 'El nick debe ser alfanum&eacute;rico'];
				// Creamos la nueva contraseña
				$key = $tsCore->passwordSL2($nuevo_nick, $_POST['password']);
				// Verificamos la IP
				$_SERVER['REMOTE_ADDR'] = $tsCore->validarIP();
            $message = ['error' => 'Su IP no se pudo validar'];
            $datos = [
            	'user_id' => $tsUser->uid, 
            	'user_email' => $tsCore->setSecure($email), 
            	'name_1' => $tsUser->nick, 
            	'name_2' => $nuevo_nick, 
            	'hash' => $key, 
            	'time' => time(), 
            	'ip' => $_SERVER['REMOTE_ADDR']
            ];
				if(insertInto([__FILE__, __LINE__], 'u_nicks', $datos)); 
					$message = ['error' => 'Proceso iniciado, recibir&aacute; la respuesta en el correo indicado cuando valoremos el cambio.'];
         break;
			case 'perfil':
            // INTERNOS
            $sitio = trim($_POST['sitio']);
            if(!empty($sitio)) $sitio = substr($sitio, 0, 4) == 'http' ? $sitio : 'http://'.$sitio;
				// EXTERNAS, Redes sociales
				$red__social = [];
				foreach ($_POST["red"] as $llave => $id) $red__social[$llave] = $tsCore->setSecure($tsCore->parseBadWords($id), true);
				$perfilData = array(
					'nombre' => $tsCore->setSecure($tsCore->parseBadWords($_POST['nombre']), true),
					'mensaje' => $tsCore->setSecure($tsCore->parseBadWords($_POST['mensaje']), true),
					'sitio' => $tsCore->setSecure($tsCore->parseBadWords($sitio), true),
					'socials' => json_encode($red__social),
					'estado' => $tsCore->setSecure($_POST['estado'])
				);
				// COMPROBACIONES
            if (!empty($perfilData['sitio']) && !filter_var($perfilData['sitio'], FILTER_VALIDATE_URL)) {
				    $message = ['error' => 'El sitio web introducido no es correcto.'];
				}
			break;
		}
		if($save == '') {
			db_exec([__FILE__, __LINE__], "query", "UPDATE u_miembros SET user_email = '{$perfilData['email']}' WHERE user_id = {$tsUser->uid}");
			if($save === '') array_splice($perfilData, 0, 1);
		}
		if($perfilData !== NULL) {
			$updates = $tsCore->getIUP($perfilData, (in_array($save, ['', 'privacidad']) ? 'user_' : 'p_'));
			if(!db_exec([__FILE__, __LINE__], "query", "UPDATE u_perfil SET {$updates} WHERE user_id = {$tsUser->uid}")) $msg_return = ['error' => show_error('Error al ejecutar la consulta de la l&iacute;nea '.__LINE__.' de '.__FILE__.'.', 'Base de datos')];
		}
		$msg_return = ['error' => 'Los cambios fueron aplicados.'];
		return $msg_return;
	}
	/*
		checkEmail()
	*/
	function isEmail($email){
		if(preg_match("/^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@([_a-zA-Z0-9-]+.)*[a-zA-Z0-9-]{2,200}.[a-zA-Z]{2,6}$/",$email)) return true;
		else return false;
	}

	
	function desCuenta() {
	global $tsUser, $tsCore;
	if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE u_miembros SET user_activo = \'0\' WHERE user_id = \''.$tsUser->uid.'\''))
	 $tsCore->redirectTo($tsCore->settings['url'].'/login-salir.php');
	 return 1;
	}
	
	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
							// MANEJAR BLOQUEOS \\
	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
    function bloqueosCambiar(){
        global $tsCore, $tsUser;
        //
        $auser = $tsCore->setSecure($_POST['user']);
        $bloquear = empty($_POST['bloquear']) ? 0 : 1;
        // EXISTE?
        $exists = $tsUser->getUserName($auser);
        // SI EXISTE Y NO SOY YO
        if($exists && $tsUser->uid != $auser){
            if($bloquear == 1){
               // YA BLOQUEADO?
					$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT bid FROM u_bloqueos WHERE b_user = \''.$tsUser->uid.'\' AND b_auser = \''.(int)$auser.'\' LIMIT 1');
                $noexists = db_exec('num_rows', $query);
                
                // NO HA SIDO BLOQUEADO
                if(empty($noexists)) {
				    if(db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO u_bloqueos (b_user, b_auser) VALUES (\''.$tsUser->uid.'\', \''.(int)$auser.'\')'))
                    return "1: El usuario fue bloqueado satisfactoriamente."; 
                } else return '0: Ya has bloqueado a este usuario.';
                // 
            } else{
			    if(db_exec(array(__FILE__, __LINE__), 'query', 'DELETE FROM u_bloqueos WHERE b_user = \''.$tsUser->uid.'\'  AND b_auser = \''.(int)$auser.'\''))
                return "1: El usuario fue desbloqueado satisfactoriamente.";
            }
        } else return '0: El usuario seleccionado no existe.';
    }
    /*
        loadBloqueos()
    */
    function loadBloqueos(){
        global $tsUser;
        //
        $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT b.*, u.user_name FROM u_miembros AS u LEFT JOIN u_bloqueos AS b ON u.user_id = b.b_auser WHERE b.b_user = \''.(int)$tsUser->uid.'\'');
        $data = result_array($query);
        
        //
        return $data;
    }
}