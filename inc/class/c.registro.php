<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Modelo para el control del registro de usuarios
 *
 * @name    c.registro.php
 * @author  PHPost Team
 */

include_once TS_EXTRA . "reCaptcha.php";

class tsRegistro extends reCaptcha {

	/**
    * @name strstr($string)
    * @access public
    * @param string
    * @return string
   */
	private function strstr($haystack, $before_needle = true) {
	   global $tsCore;
	   return empty($haystack) ? '' : $tsCore->setSecure(strstr($haystack, '@', $before_needle));
	}
   /**
    * @name checkUserEmail($pid)
    * @access public
    * @param
    * @return string
   */
	public function checkUserEmail(){
		global $tsCore;
		// Variables
		$username = htmlspecialchars($_POST['nick']);
		$email = strtolower($_POST['email']);
      $which = empty($username) ? 'email' : 'nick';
      // MENSAJE
		$valid = "1: El $which est&aacute; disponible.";	// DEFAULT
		//
		if (!empty($username) AND ctype_digit($username)) return "3: T&uacute; nick no pueder solo n&uacute;meros.";

		if(!empty($email)) {
      	$permitidos = 'gmail.com|hotmail.com|yahoo.com|live.com';
			$msg = "3: Tu proveedor no est&aacute; permitido.";
			preg_match_all('/@(' . $permitidos . ')$/i', $email, $matches);

			if(empty($matches[0][0])) return $msg;
			$decode = substr($matches[0][0], 1);
			if(!in_array($decode, explode('|', $permitidos))) return $msg;
		}
		//
		if(!empty($username) || !empty($email)) {
			$username = $tsCore->setSecure($username);
			$email = $tsCore->setSecure($email);
			$q = !empty($username) ? "user_name = '$username'" : "LOWER(user_email) = '$email'";
			$query = db_exec([__FILE__, __LINE__], 'query', "SELECT `user_id` FROM `u_miembros` WHERE $q LIMIT 1");
			if(db_exec('num_rows', $query) > 0) $valid = '0: El '.$which.' ya se encuentra registrado.';	// EXISTE
         if(db_exec('num_rows', db_exec([__FILE__, __LINE__], 'query', 
         	"SELECT id FROM w_blacklist WHERE (type = 3 && value = '{$this->strstr($email)}') || (type = 4 && value = '{$this->strstr($email, true)}') || (type = 4 && value = '$username') LIMIT 1"))) $valid = '0: Parte del '.$which.' no est&aacute; permitida';
		} else $valid = '0: Faltan datos y no se puede procesar tu solicitud.';
		// retornar valor
		return $valid;
	}
    /**
     * @name registerUser()
     * @access public
     * @param
     * @return string
     */
	function registerUser() {
		global $tsCore, $tsUser;
		// DATOS NECESARIOS
		$nac = explode('-', $_POST['nacimiento']);
		// DATOS NECESARIOS
		$tsData = array(
			'user_nick' => $tsCore->parseBadWords($_POST['nick']),
			'user_password' => $tsCore->parseBadWords($_POST['password']),
			'user_email' => $tsCore->setSecure($_POST['email']),
			'user_dia' => (int)$nac[2],
			'user_mes' => (int)$nac[1],
			'user_anio' => (int)$nac[0],
			'user_sexo' => (int)$_POST['sexo'],
			'user_terminos' => $_POST['terminos'],
			'user_captcha' => $_POST['response'],
			'user_registro' => time(),
		);
		// ERRORS
		$errors = array(
			'default' => 'El campo es requerido',
			'nick' =>'El nombre de usuario ya se encuentra registrado.',
			'password' => 'La contrase&ntilde;a tiene que ser distinta que el nick',
			'email' => 'El formato es incorrecto',
			'email_2' => 'El email ya est&aacute; en uso',
			'captcha' => 'Validaci&oacute;n incorrecta',
		);
		// COMPROBAR VACIOS
		foreach($tsData as $key => $val){
			if($val == '') return str_replace('user_', '', $key) . ": El campo es requerido";
		}
		// Verificando el captcha
      $response = parent::verify($tsData['user_captcha']);
      if (!$response) return 'recaptcha: No hemos podido validar tu humanidad';
      // COMPROBAR QUE EL NOMBRE DE USUARIO SEA VÁLIDO
      if(!preg_match("/^[a-zA-Z0-9_-]{4,16}$/", $tsData['user_nick'])) die('nick: Nombre de usuario inv&aacute;lido');

		// COMPROBAR NUEVAMENTE QUE EL USUARIO O EMAIL NO SE ENCUENTREN REGISTRADOS
		$query = db_exec([__FILE__, __LINE__], 'query', "SELECT user_name, user_email FROM u_miembros WHERE user_name = '{$tsData['user_nick']}' OR LOWER(user_email) = '{$tsData['user_email']}' LIMIT 1");
		if(db_exec('num_rows', $query) > 0 || !filter_var($tsData['user_email'], FILTER_VALIDATE_EMAIL) || $tsCore->settings['c_reg_active'] === 0) die('0: Hubo problemas al intentar registrarle, hay campos vac&iacute;os, inv&aacute;lidos o no se le permite el registro.');

		// PASAMOS BIEN... AHORA INSERTAR DATOS
		$key = $tsCore->passwordSL2($tsData['user_nick'], $tsData['user_password']);
		$rango = empty($tsCore->settings['c_reg_rango']) ? 3 : (int)$tsCore->settings['c_reg_rango'];
		$active = (int)$tsCore->settings['c_reg_active'];
		
		//
		if(db_exec([__FILE__, __LINE__], 'query', "INSERT INTO `u_miembros` (`user_name`, `user_password`, `user_email`, `user_rango`, `user_registro`, `user_activo`) VALUES ('{$tsData['user_nick']}', '$key', '{$tsData['user_email']}', $rango, {$tsData['user_registro']}, $active)")){
         $tsData['user_id'] = db_exec('insert_id');
         // INSERTAMOS EL PERFIL
			db_exec([__FILE__, __LINE__], 'query', "INSERT INTO `u_perfil` (`user_id`, `user_dia`, `user_mes`, `user_ano`, `user_sexo`) VALUES ({$tsData['user_id']}, {$tsData['user_dia']}, {$tsData['user_mes']}, {$tsData['user_anio']}, {$tsData['user_sexo']})");
         db_exec([__FILE__, __LINE__], 'query', "INSERT INTO `u_portal` (`user_id`) VALUES ('{$tsData['user_id']}')");

			# AVATAR ALEATORIO Y CONVIRTIENDO A WEBP
         $numero = rand(1,10);
			$genero = ($tsData['user_sexo'] == 1) ? 'm' : 'f';
			$imagen = $numero.'.jpg';

        	$Carpeta_Avatar =  ($tsData['user_sexo'] == 1) ? 'm' : 'f';
        	# Copiamos el avatar 120x120 a la carpeta correspondiente
        	$dirimg = TS_AVATARES . $genero . SEPARATOR . $imagen;
			$newName = TS_AVATAR . $tsData['user_id'] . '.webp';
			if (file_exists($dirimg)) {
		    	$img = imagecreatefromjpeg($dirimg);
		    	if ($img === false) {
		        	echo "Error al cargar la imagen JPEG.";
		   	} else {
		       	imagepalettetotruecolor($img);
		        	imagealphablending($img, true);
		        	imagesavealpha($img, true);
		        	if (imagewebp($img, $newName, 100)) {
		            // Conversión exitosa, continuar con otras operaciones
		            copy($dirimg, $newName);
		            imagedestroy($img);
		        	} else {
		            echo "Error al convertir la imagen a WebP.";
		        	}
		    	}
			} else {
		    	echo "La imagen de origen no existe.";
			}
        	# Realizamos la actualización en la base de datos
			db_exec([__FILE__, __LINE__], 'query', 'UPDATE u_perfil SET p_avatar = 1 WHERE user_id = \''.$tsData['user_id'].'\'');

			// MENSAJE PARA DAR LA BIENVENIDA BIENVENIDA
			$send_welcome = $tsCore->settings['c_met_welcome'];
			if($send_welcome > 0 && $send_welcome < 4) {
			$msg_bienvenida = $tsCore->parseBBCode($tsCore->settings['c_message_welcome']);
			$sexo = 'Bienvenid' . ($tsData['user_sexo'] == 1 ? 'o' : 'a'); 
			$b = array('[usuario]', '[welcome]', '[web]');
			$r = array($tsData['user_nick'], $sexo, $tsCore->settings['titulo']);
         $msg_bienvenida = str_ireplace($b, $r, $msg_bienvenida);
			
			switch($send_welcome) {
            case 1:
					db_exec([__FILE__, __LINE__], 'query', 'INSERT INTO `u_muro` (p_user, p_user_pub, p_date, p_body, p_type) VALUES (\''.(int)$tsData['user_id'].'\', \'1\', \''.time().'\', \''.$msg_bienvenida.'\', \'1\')'); 
            	$m_id = db_exec('insert_id');
					db_exec([__FILE__, __LINE__], 'query', 'INSERT INTO `u_monitor` (user_id,obj_user,obj_uno, not_type,not_total,not_menubar,not_monitor) VALUES (\''.(int)$tsData['user_id'].'\', \'1\', \''.$m_id.'\', \'12\', \'1\', \'1\', \'1\')');
				break;
            case 2:
					$preview = substr($msg_bienvenida,0,75); 
					if(db_exec([__FILE__, __LINE__], 'query', 'INSERT INTO `u_mensajes` (`mp_to`, `mp_from`, `mp_subject`, `mp_preview`, `mp_date`) VALUES ('.$tsData['user_id'].', \'1\', \''.$sexo.' a ' .$tsCore->settings['titulo'].'\', \''.$preview.'\',\''.time().'\')')) {
            		$mp_id = db_exec('insert_id');
            		db_exec([__FILE__, __LINE__], 'query', 'INSERT INTO `u_respuestas` (mp_id, mr_from, mr_body, mr_ip, mr_date) VALUES (\''.(int)$mp_id.'\', \'1\', \''.$msg_bienvenida.'\',  \''.$_SERVER['REMOTE_ADDR'].'\', \''.time().'\')'); 
            	}
				break;
		    	case 3:
					db_exec([__FILE__, __LINE__], 'query', 'INSERT INTO `u_avisos` (`user_id`, `av_subject`, `av_body`, `av_date`, `av_type`) VALUES (\''.$tsData['user_id'].'\', \''.$sexo.' a ' .$tsCore->settings['titulo'].'\', \''.$msg_bienvenida.'\', \''.time().'\', \'4\')');			
            break;
			}
		}
		// ENVIAMOS EL EMAIL
		if(empty($tsCore->settings['c_reg_activate'])){
			$key = substr(md5(time()),0,32); 
			if(db_exec([__FILE__, __LINE__], 'query', 'INSERT INTO w_contacts (user_id, user_email, time, type, hash) VALUES (\''.(int)$tsData['user_id'].'\', \''.$tsCore->setSecure($tsData['user_email']).'\', \''.time().'\', \'2\', \''.$key.'\' )')) {
				include(TS_ROOT.DIRECTORY_SEPARATOR.'inc'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'c.emails.php');
				$tsEmail = new tsEmail('activar', 'registro'); 
				$to = $tsData['user_email'];
				$subject = 'Active su cuenta';
				$body = '<div style="background:#0f7dc1;padding:10px;font-family:Arial, Helvetica,sans-serif;color:#000"><h1 style="color:#FFFFFF; font-weight:bold; font-size:30px;">'.$tsCore->settings['titulo'].'</h1><div style="background:#FFF;padding:10px;font-size:14px"><h2 style="font-family:Arial, Helvetica,sans-serif;color:#000;font-size:22px">Hola '.$tsData['user_nick'].'</h2><p style="font-family:Arial, Helvetica,sans-serif;color:#000">&iexcl;Te damos la bienvenida a '.$tsCore->settings['titulo'].'!</p><p>Para finalizar con el proceso de registro, confirma tu direcci&oacute;n de email accediendo a <a href="'.$tsCore->settings['url'].'/validar/'.$key.'/2/'.$tsCore->setSecure($tsData['user_email']).'">este enlace</a></p><br /> <br /><p>Posteriormente podr&aacute; acceder con las siguientes credenciales:</p><p>Usuario: '.$tsData['user_nick'].' <br /> Contrase&ntilde;a: '.$tsData['user_password'].'</p><br /><p>Antes de empezar a interactuar con la comunidad, te recomendamos que visites el <a target="_blank" href="http://'.$tsCore->settings['url'].'/pages/protocolo/">Protocolo</a> del sitio.</p><p>Esperamos que disfrutes enormemente tu visita.</p><p>&iexcl;Te damos la bienvenida a Muchas gracias!</p><p>Staff de '.$tsCore->settings['titulo'].'.</p><div style="border-top:#CCC solid 1px;padding:10px 0"><span style="color:#666;font-size:11px"><center>El staff de <strong>'.$tsCore->settings['titulo'].'</strong></center></span></div></div></div>';
				// <--
				$tsEmail->emailTo = $to;
				$tsEmail->emailSubject = $subject;
				$tsEmail->emailBody = $body;
				$tsEmail->emailHeaders = $tsEmail->setEmailHeaders();
				$tsEmail->sendEmail($from, $to, $subject, $body)  or die('0: Hubo un error al intentar procesar lo solicitado');
				return '1: <div class="box_cuerpo">Te hemos enviado un correo a <strong>'.$to.'</strong> con los &uacute;ltimos pasos para finalizar con el registro.<br><br>Si en los pr&oacute;ximos minutos no lo encuentras en tu bandeja de entrada, por favor, revisa tu carpeta de correo no deseado, es posible que se haya filtrado.<br><br>&iexcl;Muchas gracias!</div>';	
			}else{
				return '0: <div class="box_cuerpo" style="padding: 12px 20px; border-top:1px solid #CCC">Ocurri&oacute; un error, int&eacute;ntelo de nuevo.</div>';				
			}
		} else {
			$tsUser->userActivate($tsData['user_id'],md5($tsData['user_registro']));
			$tsUser->loginUser($tsData['user_nick'], $tsData['user_password'], true);
			return '2: <div class="box_body"><h1>🎉 Felicidades 🎉</h1><p>Ya eres parte de <strong>'.$tsCore->settings['titulo'].'</strong>! Ahora puedes disfrutar y compartir todo el contenido que existe en nuestra comunidad sin ninguna restricción, y tu cuenta ha sido activada.<br>¡Muchas gracias!</p><a data-change href="'.$tsCore->settings['url'].'/cuenta/" class="btn btn-gradient-six mt-4 d-inline-block">Comenzar Ahora!</a></div>';
		}
	} else return '0: Ocurrio un error, intentalo ma&aacute;s tarde.';
	}
	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
}