<?php

/**
 * Index :: Control del instalador
 * Instalador modificado desde cero y mejorado
 *
 * @package SLV3 Install
 * @author Miguel92 
 * @copyright Syntaxis Lite 2024
 * @version v3.0 01-03-2024
 * @link https://phpost.es
*/

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
session_start();

require_once realpath(__DIR__) . DIRECTORY_SEPARATOR . 'syntaxislitev3.php';
if(file_exists(ARCHIVO_LOCK)) header("Location: ../");

switch ($step) {
	case 0:
		# Pantalla de bienvenida
		# Información sobre las versiones y extensiones necesarias
	break;
	case 1:
      $_SESSION['license'] = false;
      $licence = file_get_contents(LICENSE);
      $accion_form = ($next == true) ? 'index.php?step=2' : '';
	break;
	case 2:
		if ($_POST['license']) {
		
			foreach($checkPerms as $cpkey => $check) {
				$newkey = pathinfo($check, PATHINFO_BASENAME);
				if($newkey == 'config.inc.php') $newkey = "config";
				$permisos[$newkey]['icon'] = is_dir($check) ? "solar:folder-bold-duotone" : "solar:code-file-bold-duotone";
				$permisos[$newkey]['root'] = str_replace(ROUTEGENERAL, '..\\', $check);
				$permisos[$newkey]['chmod'] = (int)substr(sprintf('%o', fileperms($check)), -3);
				$permisos[$newkey]['css'] = 'success';
				if ($newkey === 'config' && $permisos[$newkey]['chmod'] != 666) {
					$permisos[$newkey]['css'] = 'danger';
					$next = false;
				} elseif ($newkey != 'config' && $permisos[$newkey]['chmod'] != 777) {
					$permisos[$newkey]['css'] = 'danger';
					$next = false;
				}
			}
			$_SESSION['license'] = true;
		} else header("Location: index.php");
      $accion_form = ($next == true) ? "index.php?step=3" : "index.php?step=1";
	break;
	case 3:
		// No saltar la licencia
      if (!$_SESSION['license']) header("Location: index.php");
      $next = false;
      $accion_form = '';
      if (isset($_POST['save'])) {
         // Con esto evitamos escribir todos los campos
         foreach ($_POST['db'] as $key => $val) $db[$key] = empty($val) ? '' : htmlspecialchars($val);
         // Verificamos que todos los campos esten llenos
         if (empty($db["hostname"]) || empty($db["username"]) || (empty($db["password"]) && !$Install->is_localhost()) || empty($db["database"])) $message = 'Todos los campos son requeridos';
         else {
            // NO SE PUDO CONECTAR?
            $database->db = $db;
            $database->db_link = $database->conn();
            if (empty($database->db_link)) {
               $message = 'Tus datos de conexi&oacute;n son incorrectos.';
               $next = false;
            } else {
               $database->setNames();
               // GUARDAR LOS DATOS DE CONEXION
               $FileConfig = file_get_contents(CONFIG);
               $FileConfig = str_replace(['dbhost', 'dbuser', 'dbpass', 'dbname'], $db, $FileConfig);
               file_put_contents(CONFIG, $FileConfig);
               // ELIMINAMOS LAS TABLAS QUE EXISTAN EN LA BASE
               $result = $database->query("SHOW TABLES");
               while ($row = $result->fetch_row()) $database->query("DROP TABLE {$row[0]}");
               // INSERTAR DB
               require_once INSTALL . 'database.php';
               $bderror = '';
               foreach ($syntaxis_lite as $tbl => $sentecia) {
                  if ($database->query($sentecia)) $exe[$tbl] = 1;
                  else {
                     $exe[$tbl] = 0;
                     $bderror .= '<br/>' . print_r(mysqli_error($db_link));
                  }
               }
               if (!in_array(0, $exe)) header("Location: index.php?step=4");
               else {
                  $message = 'Lo sentimos, pero ocurrió un problema. Inténtalo nuevamente; borra las tablas que se hayan guardado en tu base de datos: ' . $bderror;
               }
            }
         }
      }
   break;
   case 4:
		// No saltar la licencia
      if (!$_SESSION['license']) header("Location: index.php");
      $next = false;
      $accion_form = '';
      if (isset($_POST['save'])) {
         // Con esto evitamos escribir todos los campos
         foreach($_POST['web'] as $key => $val) $web[$key] = htmlspecialchars($val);
         // Verificamos que todos los campos esten llenos
         if (in_array('', $web)) $message = 'Todos los campos son requeridos';
         else {
            // DATOS DE CONEXION
            require_once CONFIG;
            // CONECTAMOS
            $database->db = $db;
            $database->db_link = $database->conn();
            $database->setNames();
            //
            if ($db['hostname'] === 'dbhost' OR $database->num_rows('SELECT user_id FROM u_miembros WHERE user_id = 1 || user_rango = 1')) $message = 'Vuelva al paso anterior, no se han guardado los datos de acceso correctamente.';
            // Cambia el nombre de la categoría Syntaxis Lite por el del sitio web creado
            require_once ROUTEPLUGINS . 'modifier.seo.php';
            $name = $database->escape($web['name']);
            $seo = smarty_modifier_seo($name);
            // Actualizamos
            $database->query("UPDATE `p_categorias` SET c_nombre = '$name', c_seo = '$seo' WHERE cid = 30 LIMIT 1");
            // Insertamos en w_temas
            $database->query("INSERT INTO w_temas (tid, t_name, t_url, t_path, t_copy) VALUES({$theme['tid']}, '{$theme['t_name']}', '{$web['url']}{$theme['t_url']}', '{$theme['t_path']}', '{$theme['t_copy']}')");
            // GUARDAR LOS DATOS DE CONEXION
            $FileConfig = file_get_contents(CONFIG);
            $FileConfig = str_replace(['dbpkey', 'dbskey'], [$web['pkey'], $web['skey']], $FileConfig);
            file_put_contents(CONFIG, $FileConfig);
            // Publicidad
            $linkad = "https://phpost.es/";
            $sizesad = ['160x600','300x250','468x60','728x90'];
            foreach ($sizesad as $key => $ad) {
               $width = explode('x', $ad)[0];
               $height = explode('x', $ad)[1];
               $html = "<a href=\"$linkad\" target=\"_blank\"><img alt=\"ads $ad\" title=\"Publicidad $ad\" width=\"$width\" height=\"$height\" src=\"https://phpost.es/feed/ads/ad$ad.png\"></a>";
               $set[] = "ads_" . explode('x', $ad)[0] . " = '" . html_entity_decode($html) . "'";
            }
            $ads = join(', ', $set);
            $database->query("UPDATE w_ads SET $ads WHERE asd_id = 1");

            $newdata = [
            	'seo_portada' => $web['url'] . '/public/assets/images/portada.png',
            	'seo_favicon' => $web['url'] . '/public/assets/images/SyntaxisLite-ico-64.png',
            	'seo_imagenes' => serialize([
            		16 => $web['url'] . '/public/assets/images/SyntaxisLite-ico-16.png',
            		32 => $web['url'] . '/public/assets/images/SyntaxisLite-ico-32.png',
            		64 => $web['url'] . '/public/assets/images/SyntaxisLite-ico-64.png'
            	])
            ];
            $database->query("UPDATE w_seo SET {$Install->getIUP($newdata)} WHERE wid = 1");

            // UPDATE
            $wConfig = [
               'titulo' => $web['name'],
               'slogan' => $web['slogan'],
               'url' => $web['url'],
               'email' => $web['mail'],
               'idioma' => 'es-ES',
               'version' => $ConfigInstall['version_a'],
               'version_code' => $ConfigInstall['version_b'],
               'pkey' => $web['pkey'],
               'skey' => $web['skey']
            ];

            if ($database->query("UPDATE w_configuracion SET {$Install->getIUP($wConfig)} WHERE tscript_id = 1")) header("Location: index.php?step=5");
            else $message = $database->error();
         }
      }
   break;
   case 5:
   	// No saltar la licencia
      if (!$_SESSION['license']) header("Location: index.php");
      // Step
      $next = false;
      $accion_form = '';
      if (isset($_POST['save'])) {
         // Con esto evitamos escribir todos los campos
         foreach ($_POST['user'] as $key => $val) $user[$key] = htmlspecialchars($val);
         // Evitamos que los campos esten vacios
         if(in_array('', $user)) $message = 'Todos los campos son requeridos';
         else {
            if(!ctype_alnum($user['name'])) 
               $message = 'Introduzca un nombre de usuario alfanum&eacute;rico';
            //
            if(!filter_var($user['mail'], FILTER_VALIDATE_EMAIL))
               $message = 'Introduzca un email correcto.';
            //
            if($user['pass'] !== $user['passc']) 
               $message = 'Las contrase&ntilde;as no coinciden.';
            $key = $Install->passwordSL2($user['name'], $user['passc']);
            $time = time();
            // DATOS DE CONEXION
            require_once CONFIG;
            // CONECTAMOS
            $database->db = $db;
            $database->db_link = $database->conn();
            $database->setNames();
            //COMPROBAMOS QUE NO HAYA ADMINISTRADORES Y/O EL PRIMER USUARIO REGISTRADO
            if($database->num_rows("SELECT user_id FROM u_miembros WHERE user_id = 1 OR user_rango = 1 LIMIT 1")) {
               $message = 'No se puede registrar, ya existe un administrador.';
               $body = "<html><head></head><body><p>Un lammer ha entrado a su instalador. <br /> <br /> <b>Sitio web:</b> {$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}<br /> <b>IP:</b> {$_SERVER['REMOTE_ADDR']}<br /> <b>Usuario:</b> {$user['name']}<br /> <b>Password:</b> {$user['pass']}<br /> <b>Email:</b> {$user['mail']}</p></body></html>";
               mail('joel92@live.com.ar', 'Lammer detectado', $body, 'Content-type: text/html; charset=iso-8859-15');
            } else {
               //INSERTAMOS AL FUNDADOR DE LA WEB
               $database->query("INSERT INTO u_miembros (user_name, user_password, user_email, user_rango, user_registro, user_puntosxdar, user_activo) VALUES ('{$user['name']}', '$key', '{$user['mail']}', 1, $time, 50, 1)");
               $user_id = (int)$database->insert_id();
               // DEMAS TABLAS
               $avatar = "https://ui-avatars.com/api/?name={$user['name']}&background=D6030B&color=fff&size=160&font-size=0.50&bold=false&length=2";
               copy($avatar, ROUTEAVATAR . "{$user_id}.webp");
      
               $database->query("INSERT INTO u_perfil (user_id, p_avatar) VALUES ($user_id, 1)");
               $database->query("INSERT INTO u_portal (user_id) VALUES ($user_id)");
               // UPDATE
               $database->query("UPDATE p_posts SET post_user = $user_id, post_category = 30, post_date = $time WHERE post_id = 1");
               $database->query("UPDATE w_stats SET stats_time_foundation = $time, stats_time_upgrade = $time WHERE stats_no = 1");
               // DAMOS BIENVENIDA POR CORREO
               mail($user['mail'], 'Su comunidad ya puede ser usada', "<html><head><title>Su nueva comunidad Link Sharing est&aacute; lista!</title></head><body><p>Estas son sus credenciales de acceso:</p><p>Usuario: {$user['name']}</p><p>Contrase&ntilde;a: {$user['pass']}</p><br />Gracias por usar <a href=\"$script_web\"><b>PHPost Risus</b></a> para compartir enlaces :)</body></html>", 'Content-type: text/html; charset=iso-8859-15');
               //
               header("Location: index.php?step=6&uid=$user_id");
            }
         }
      }
   break;
   case 6:
      // No saltar la licencia
      if (!$_SESSION['license']) header("Location: index.php");
      // DATOS DE CONEXION
      require_once CONFIG;
      // CONECTAMOS
      $database->db = $db;
      $database->db_link = $database->conn();
      $database->setNames();
      //
      $data = $database->fetch_assoc("SELECT titulo, slogan, url, version_code FROM w_configuracion WHERE tscript_id = 1");
      if (isset($_POST['save'])) header("Location: {$data['url']}");
      else {
         // CONSULTA
         $user_id = (int)$_GET['uid'];
         $udata = $database->fetch_assoc("SELECT user_id, user_name FROM u_miembros WHERE user_id = $user_id");
         // ESTADISTICAS
         $code = [
            'w' => $data['titulo'], 
            's' => $data['slogan'], 
            'u' => str_replace(['https://','http://'], '', $data['url']), 
            'v' => $data['version_code'], 
            'a' => $udata['user_name'], 
            'i' => $udata['user_id']
         ];

         $key = base64_encode(serialize($code));
         // Abrir el archivo en modo de escritura ("w")
         $handle = fopen(ARCHIVO_LOCK, "w");
         // Escribir los datos en el archivo
         fwrite($handle, $key);
         // Cerrar el archivo
         fclose($handle);
      }
   break;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" data-bs-theme="dark">
<head>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="PHPost" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="<?=$base_url?>/assets/SyntaxisLite-ico-64.ico?<?=time()?>" type="image/x-icon" />
<title>Instalaci&oacute;n de <?=$ConfigInstall['version_a']?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_url?>/assets/estilo.css?<?=time()?>" rel="stylesheet" type="text/css" />
</head>
<body>
   <main>

      <header class="bg-dark-subtle p-3 position-sticky top-0" style="z-index: 99;">
         <h1 class="h3">Programa de instalaci&oacute;n: <strong class="text-success-emphasis"><?=$ConfigInstall['version_a']?></strong></h1>
      </header>

      <section class="position-relative container my-2 mx-auto">
      	<?php if($step == 0): ?>
      		<div class="p-5">
               <h4 class="m-0 py-2">Bienvenidos a la instalación de: <span class="text-success-emphasis"><?=$ConfigInstall['version_a']?></span></h4>
               <p>Antes de empezar debes tener estas extensiones y versión de PHP actualizadas/activadas para no tener problemas al usar el script, en caso contrario que alguno de las extensiones no esten habilitadas, podrás utilizarlas igual, pero tendrás problemas en algunas ocaciones.</p>
               <div class="row row-cols-2">
               	<div class="col">
               		 <?php $php = $Install->checkVersionPHP(); ?>
			            <div class="my-3 check-version">
			            	<div class="icon d-flex justify-content-center align-items-center rounded shadow bg-<?= $php['clase'] ?>"><iconify-icon icon="<?=$php['icono']?>"></iconify-icon></div>
			            	<div class="info">
				            	<span class="d-block">PHP: <strong><?= $php['version'] ?></strong></span>
				            	<span class="d-flex justify-content-start align-items-center gap-2 text-<?= $php['clase'] ?>-emphasis"><?= $php['mensaje'] ?></span>
				            </div>
			            </div>
               	</div>
               	<div class="col">
               		<div class="my-3 check-version">
			            	<div class="icon rounded shadow bg-success"><iconify-icon icon="solar:check-read-line-duotone"></iconify-icon></div>
			            	<div class="info">
				            	<span class="d-block">Smarty: <strong>4.3.2</strong></span>
				            	<span class="d-flex justify-content-start align-items-center gap-2 text-success-emphasis">Actualizada a la versión 4.3.2</span>
				            </div>
			            </div>
               	</div>
						<?php foreach($Install->checkExtension() as $name => $check): ?>
							<div class="col">
				            <div class="my-3 check-version">
				            	<div class="icon rounded shadow bg-<?= $check['clase'] ?>"><iconify-icon icon="<?=$check['icono']?>"></iconify-icon></div>
				            	<div class="info">
					            	<span class="d-block"><span class="text-uppercase"><?=$name?></span>: <strong><?= $check['version'] ?></strong> <span class="text-<?= $check['clase'] ?>-emphasis"><?= $check['mensaje'] ?></span></span>
					            	<small><em><?= $check['nota'] ?></em></small>
					            	
				            	</div>
				            </div>
				          </div>
						<?php endforeach; ?>
               </div>

               <div class="text-center">
               	<a href="?step=1" class="btn btn-success">Empezar con la instalación</a>
               </div>
               
            </div>
      	<?php elseif($step > 0 && $step < 8): ?>
      		<form action="<?= $accion_form; ?>" method="post" id="form" autocomplete="OFF">
               <fieldset>
               	<?php if($step == 1): ?>
	                  <legend>Licencia</legend>
	                  <p>Para utilizar <strong><?=$ConfigInstall['version_a']?></strong> debes estar de acuerdo con nuestra licencia de uso.</p>
	                  <textarea name="license" class="form-control border-0 bg-dark-subtle p-3" style="resize: none;" rows="20"><?= $licence; ?></textarea>
	                  <p class="py-2 text-center"><input type="submit" class="btn btn-success" value="Acepto la licencia, continuar..."/></p>
	               <?php elseif($step == 2): ?>
	               	<legend>Permisos de escritura</legend>
	                  <p>Los siguientes archivos y directorios requieren de permisos especiales, debes cambiarlos desde tu cliente FTP, los archivos deben tener permiso <strong>666</strong> y los direcorios <strong>777</strong></p>
	                  <div class="row row-cols-sm-auto row-cols-lg-auto">
		                  <?php foreach ($permisos as $name => $val): 
		                     $txt = ($val['css'] === 'success') ? 'Permisos aplicados correctamente' : $val['status'];		                     
		                  ?>
		                     <div class="col mb-4">
		                     	<div class="permisos">
		                     		<div class="icon">
			                     		<iconify-icon icon="<?=$val['icon']?>"></iconify-icon>
			                     	</div>
			                     	<div class="data">
				                        <span for="<?=$key?>"><code><?=$val['root']?></code></span>
				                        <span class="d-block status text-<?=$val['css']?>-emphasis"><?=$txt?></span>
				                     </div>
			                     </div>
			                  </div>
		                  <?php endforeach; ?>
	                  </div>
	                  <p class="py-2 text-center"><input type="submit" class="btn btn-<?=($next == true ? 'success' : 'danger') ?>" value="<?=($next == true ? 'Continuar con la instalación &raquo;' : 'Volver a verificar') ?>"/></p>
	               <?php elseif($step == 3): ?>
	               	<legend>Base de datos</legend>
	                  <p>Ingresa tus datos de conexi&oacute;n a la base de datos.</p>
	                  <?= (isset($_SERVER['message']) ? '<div class="alert alert-danger">' . $_SERVER['message'] . '</div>' : '') ?>
	                  <div class="w-50 mx-auto">
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" name="db[hostname]" id="Servidor" placeholder="localhost" value="<?=(empty($db['hostname']) ? '' : $db['hostname'])?>" required>
								 	<label for="Servidor">Servidor</label>
								 	<small class="text-success-emphasis">Donde est&aacute; la base de datos, ej: <strong>localhost</strong></small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="Usuario" name="db[username]" placeholder="root" value="<?=(empty($db['username']) ? '' : $db['username'])?>" required>
								 	<label for="Usuario">Usuario</label>
								 	<small class="text-success-emphasis">El usuario de tu base de datos.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="Contrasena" name="db[password]" placeholder="" value="<?=(empty($db['password']) ? '' : $db['password'])?>">
								 	<label for="Contrasena">Contrase&ntilde;a</label>
								 	<small class="text-success-emphasis">Para acceder a la base de datos.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="BaseDeDatos" name="db[database]" placeholder="mydatabase" value="<?=(empty($db['database']) ? '' : $db['database'])?>" required>
								 	<label for="BaseDeDatos">Base de datos</label>
								 	<small class="text-success-emphasis">Nombre de la base de datos para tu web.</small>
								</div>
							</div>
	                  <p class="py-2 text-center"><input type="submit" class="btn btn-success" name="save" value="Instalar la base de datos &raquo;"/></p>
	               <?php elseif($step == 4): ?>
	               	<legend>Datos del sitio</legend>
	                  <?= (isset($message) ? '<div class="alert alert-danger">' . $message . '</div>' : '') ?>
	                  <div class="w-50 mx-auto">
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="Nombre" name="web[name]" placeholder="<?=$ConfigInstall['nombre']?>" value="<?=(empty($web['name']) ? '' : $web['name'])?>" required>
								 	<label for="Nombre">Nombre</label>
								 	<small class="text-success-emphasis">El t&iacute;tulo de tu web.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="Slogan" name="web[slogan]" placeholder="<?=$ConfigInstall['slogan']?>" value="<?=(empty($web['slogan']) ? '' : $web['slogan'])?>" required>
								 	<label for="Slogan">Slogan</label>
								 	<small class="text-success-emphasis">Una breve descripción para tu sitio web.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="Direccion" name="web[url]" value="<?=(empty($web['url']) ? $url : $web['url'])?>" required>
								 	<label for="Direccion">Direcci&oacute;n</label>
								 	<small class="text-success-emphasis">Ingresa la url donde  est&aacute; alojada tu web, sin la &uacute;ltima diagonal.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="email" class="form-control" autocomplete="off" id="Email" name="web[mail]" placeholder="example@server.com" value="<?=(empty($web['mail']) ? '' : $web['mail'])?>" required>
								 	<label for="Email">Email</label>
								 	<small class="text-success-emphasis">Email de la web o del administrador.</small>
								</div>
	                  	<legend>Datos de reCAPTCHA</legend>
	                  	<p>Obtén tu clave desde <a href="https://www.google.com/recaptcha/admin" target="_blank"><strong>www.google.com/recaptcha/admin</strong></a></p>
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="pkey" name="web[pkey]" value="<?=(empty($web['pkey']) ? '' : $web['pkey'])?>" placeholder="6LfFFiMdAAAAAAQjDafWXZ0FeyesKYjVm4DSUoao" required>
								 	<label for="pkey">Clave pública del sitio</label>
								 	<small class="text-success-emphasis">Clave pública del sitio.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" autocomplete="off" id="skey" name="web[skey]" value="<?=(empty($web['skey']) ? '' : $web['skey'])?>" placeholder="6LfFFiMdAAAAAFIP4oNFLQx5Fo1FyorTzNps8ChE" required>
								 	<label for="skey">Clave secreta</label>
								 	<small class="text-success-emphasis">Clave secreta.</small>
								</div>
							</div>
	                  <p class="py-2 text-center"><input type="submit" name="save" class="btn btn-success" value="Instalar datos del sitio &raquo;"/></p>
	               <?php elseif($step == 5): ?>
	               	<legend>Administrador</legend>
	                  <p>Ingresa tus datos de usuario, m&aacute;s adelante debes editar tu cuenta para ingresar datos como, fecha de nacimiento, lugar de residencia, etc.</p>
	                  <?= (isset($message) ? '<div class="alert alert-danger">' . $message . '</div>' : '') ?>
	                  <div class="w-50 mx-auto">
		                  <div class="form-floating mb-3">
								  	<input type="text" class="form-control" id="Nombre" name="user[name]" autocomplete="off" placeholder="Nombre de usuario" value="<?=(empty($user['name']) ? '' : $user['name'])?>" required>
								 	<label for="Nombre">Nombre de usuario</label>
								 	<small class="text-success-emphasis">Tu nombre de usuario (nick).</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="password" class="form-control" id="Contrasena" name="user[pass]" autocomplete="off" placeholder="Contrasena" value="<?=(empty($user['pass']) ? '' : $user['pass'])?>" required>
								 	<label for="Contrasena">Contrase&ntilde;a</label>
								 	<small class="text-success-emphasis">Tu contrase&ntilde;a para tu cuenta.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="password" class="form-control" id="Confirmar" name="user[passc]" autocomplete="off" placeholder="Confirmar" value="<?=(empty($user['passc']) ? '' : $user['passc'])?>" required>
								 	<label for="Confirmar">Confirmar contrase&ntilde;a</label>
								 	<small class="text-success-emphasis">Ingresa tu contrase&ntilde;a nuevamente.</small>
								</div>
		                  <div class="form-floating mb-3">
								  	<input type="email" class="form-control" id="Email" name="user[mail]" autocomplete="off" placeholder="Emailo" value="<?=(empty($user['mail']) ? '' : $user['mail'])?>" required>
								 	<label for="Email">Email</label>
								 	<small class="text-success-emphasis">Ingresa tu direcci&oacute;n de email.</small>
								</div>
	                  </div>
	                  <p class="py-2 text-center"><input type="submit" name="save" class="btn btn-success" value="Instalar datos del usuario &raquo;"/></p>
	               <?php elseif($step == 6): ?>
	               	<div class="d-flex justify-content-center align-items-center flex-column">
	                     <img class="rounded image-end" src="<?=$base_url?>/assets/SyntaxisLite-ico.png?<?=time()?>" alt="<?=$ConfigInstall['version_a']?>">
	                     <h4 class="m-0 py-2">Bienvenido a <?=$ConfigInstall['nombre']?></h4>
	                     <form action="https://phpost.es/feed/index.php?type=install" method="post" id="form">
	                        <small class="text-danger-emphasis">Al finalizar se eliminá la carpeta <strong><?= basename(getcwd()); ?></strong>.</small>
	                        <fieldset class="py-3 w-75 mx-auto">
	                           <p class="lead d-block text-center">Gracias por instalar <strong><?=$ConfigInstall['version_a']?></strong>, ya est&aacute; lista tu nueva comunidad <strong>Link Sharing System</strong>. S&oacute;lo inicia sesi&oacute;n con tus datos y comienza a disfrutar. Ahora no dejes de <a href="https://www.phpost.es" rel="external" target="_blank" class="text-decoration-none fw-bold text-success-emphasis">visitarnos</a> para estar pendiente de futuras actualizaciones. Recuerda reportar cualquier bug que encuentres, de esta manera todos ganamos.</p>
	                        </fieldset>
	                        <span class="grupos mb-3">Sumate a nuestros grupos:
	                           <a sthref="https://discord.gg/mx25MxAwRe" ´rel="external" class="text-decoration-none fw-bold text-primary-emphasis" target="_blank">Discord</a> - 
	                           <a sthref="https://t.me/PHPost23" ´rel="external" class="text-decoration-none fw-bold text-primary-emphasis" target="_blank">Telegram</a>
	                        </span>
	                        <center>
	                           <input type="hidden" name="key" value="<?= $key; ?>" />
	                           <input type="submit" value="Finalizar la instalación" class="btn btn-success"/>
	                       </center>
	                    </form>
                  	</div>
	               <?php endif; ?>
               </fieldset>
            </form>
      	<?php endif; ?>
      </section>

      <footer class="d-flex justify-content-between align-items-center p-2 small">
      	<p>Powered by <a class="fw-bold text-light-emphasis text-decoration-none" href="https://www.phpost.es" target="_blank">PHPost</a> - Copyright &copy; <?=date('Y')?></p>
      	<p>Actualizado por <a class="fw-bold text-light-emphasis text-decoration-none" href="https://t.me/JvalenteM92" alt="perfil telegram" title="Mi perfil en telegram" target="_blank">Miguel92</a></p>
      </footer>
   </main>
   <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>
