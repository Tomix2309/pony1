<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Controlador AJAX
 *
 * @name    ajax.upload.php
 * @author  PHPost Team
*/
/**********************************\

*	(VARIABLES POR DEFAULT)		*

\*********************************/

	// NIVELES DE ACCESO Y PLANTILLAS DE CADA ACCIÓN
	$files = array(
      'upload-cambiar' => array('n' => 2, 'p' => 'cambiar'),
      'upload-subir' => array('n' => 2, 'p' => ''),
      'upload-avatar' => array('n' => 2, 'p' => ''),
      'upload-crop' => array('n' => 2, 'p' => ''),
		'upload-images' => array('n' => 2, 'p' => ''),
	);

/**********************************\

* (VARIABLES LOCALES ESTE ARCHIVO)	*

\*********************************/

	// REDEFINIR VARIABLES
	$tsPage = 'php_files/p.upload.'.$files[$action]['p'];
	$tsLevel = $files[$action]['n'];
	$tsAjax = empty($files[$action]['p']) ? 1 : 0;

/**********************************\

*	(INSTRUCCIONES DE CODIGO)		*

\*********************************/
	
	// DEPENDE EL NIVEL
	$tsLevelMsg = $tsCore->setLevel($tsLevel, true);
	if($tsLevelMsg != 1) { echo '0: '.$tsLevelMsg['mensaje']; die();}
	// CLASE
	require('../class/c.upload.php');
	$tsUpload = new tsUpload();
	// CODIGO
	switch($action){
      case 'upload-cambiar':
        	$sex = $tsUpload->sexuser();
        	$Carpeta_Avatar = ($sex["user_sexo"] == 1) ? 'm' : 'f';
			$smarty->assign('tsCarpeta', "{$tsCore->settings['avatares']}/$Carpeta_Avatar");
			$Avatar = array_diff(scandir(TS_AVATARES . $Carpeta_Avatar), ['.', '..', 'Thumbs.db']);
			foreach($Avatar as $k => $ava) 
				$Avatar[$k] = [
					'img' => $ava,
					'name' => str_replace('.jpg', '', $ava)
				];
			$smarty->assign('tsAvatares', $Avatar);
      break;
      case 'upload-subir':
        	$sex = $tsUpload->sexuser();
        	$Carpeta_Avatar =  ($sex["user_sexo"] == 1) ? 'm' : 'f';
        	# Copiamos el avatar 120x120 a la carpeta correspondiente
        	$dirimg = TS_AVATARES . $Carpeta_Avatar . SEPARATOR . $_POST['id'] . '.jpg';
			$newName = TS_AVATAR . $_POST['usuario'] . '.default.webp';
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
			db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE u_perfil SET p_avatar = 1 WHERE user_id = \''.$sex["user_id"].'\'');
			# Mostramos la imagen actualizada, y reemplazamos con jquery
			echo $tsCore->settings['avatar'] . '/' . $_POST['usuario'] . '.default.webp?' . time();
      break;
      case 'upload-gravatar': 
			$email = $_POST['email_gravatar'];
			$size = $_POST['size'];
			$types = $_POST['type']; // '404', 'mp', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash'
			$ranking = $_POST['ranking']; // 'g', 'pg', 'r', 'x'
			$img_tag = true;

      	echo $tsUpload->getGravatar();
      break;
      case 'upload-avatar':
         // <--
         $tsUpload->image_scale = true;
         $tsUpload->image_size['w'] = 640;
         $tsUpload->image_size['h'] = 480;
         //
         $tsUpload->file_url = $_POST['url'];
         //
         $result = $tsUpload->newUpload(3);
         echo $tsCore->setJSON($result);
         // -->
      break;
      case 'upload-crop':
         // <--
         echo $tsCore->setJSON($tsUpload->cropAvatar($tsUser->uid));
			db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE u_perfil SET p_avatar = \'1\' WHERE user_id = \''.$tsUser->uid.'\'');
         // -->
     	break;
		case 'upload-images':
         echo $tsCore->setJSON($tsUpload->newUpload(1));
		break;
	}