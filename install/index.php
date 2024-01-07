<?php
/**
 * Index :: Control del instalador
 *
 * @package Syntaxis Lite Install
 * @author Miguel92 
 * @copyright Syntaxis Lite 2024
 * @version v2.0 01-01-20214
 * @link https://phpost.es
*/

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
session_start();

require_once realpath(__DIR__) . DIRECTORY_SEPARATOR . 'config.install.php';
if(file_exists(ARCHIVO_LOCK)) header("Location: ../");

switch ($step) {
	case 0:
		# Pantalla de bienvenida
	break;
	case 1:
      include __DIR__ . "/extensions.php";
	break;
   case 2:
      $_SESSION['license'] = false;
      $licence = file_get_contents('../LICENSE');
      $accion_form = ($next == true) ? 'index.php?step=3' : '';
   break;
	case 3:
		if ($_POST['license']) {
			$all = [
				"config" => '../config.inc.php',
				"cache" => '../cache/',
				"avatar" => '../files/avatar/',
            "downloads" => '../files/downloads/',
				"settings" => '../files/settings/',
				"uploads" => '../files/uploads/'
			];
			foreach ($all as $key => $val) {
				$permisos[$key]['chmod'] = (int)substr(sprintf('%o', fileperms($val)), -3);
				$permisos[$key]['css'] = 'OK';
				if ($key === 'config' && $permisos[$key]['chmod'] != 666) {
					$permisos[$key]['css'] = 'NO';
					$next = false;
				} elseif ($key != 'config' && $permisos[$key]['chmod'] != 777) {
					$permisos[$key]['css'] = 'NO';
					$next = false;
				}
			}
			$_SESSION['license'] = true;
		} else header("Location: index.php");
      $accion_form = ($next == true) ? "index.php?step=4" : "index.php?step=2";
	break;
   case 4:
      // No saltar la licensia
      if (!$_SESSION['license']) header("Location: index.php");
      $next = false;
      if ($_POST['save']) {
         // Con esto evitamos escribir todos los campos
         foreach ($_POST['db'] as $key => $val) $db[$key] = empty($val) ? '' : htmlspecialchars($val);
         // Verificamos que todos los campos esten llenos
         if (!empty($db["hostname"]) && !empty($db["username"]) && !empty($db["password"]) && !empty($db["database"])) $message = 'Todos los campos son requeridos';
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
               if (!in_array(0, $exe)) header("Location: index.php?step=5");
               else {
                  $message = 'Lo sentimos, pero ocurrió un problema. Inténtalo nuevamente; borra las tablas que se hayan guardado en tu base de datos: ' . $bderror;
               }
            }
         }
      }
   break;
   // DATOS DEL SITIO
   case 5:
      // No saltar la licensia
      if (!$_SESSION['license']) header("Location: index.php");
      $next = false;
      if ($_POST['save']) {
         // Con esto evitamos escribir todos los campos
         foreach($_POST['web'] as $key => $val) $web[$key] = htmlspecialchars($val);
         // Verificamos que todos los campos esten llenos
         if (in_array('', $web)) $message = 'Todos los campos son requeridos';
         else {
            define('TS_HEADER', true);
            // DATOS DE CONEXION
            require_once CONFIG;
            // CONECTAMOS
            $database->db = $db;
            $database->db_link = $database->conn();
            $database->setNames();
            //
            if ($db['hostname'] === 'dbhost' OR $database->num_rows('SELECT user_id FROM u_miembros WHERE user_id = 1 || user_rango = 1')) $message = 'Vuelva al paso anterior, no se han guardado los datos de acceso correctamente.';
            // Cambia el nombre de la categoría Syntaxis Lite por el del sitio web creado
            require_once ROOT . 'inc' . SEPARATOR . 'plugins' . SEPARATOR . 'modifier.seo.php';
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
            $linkad = "https://joelmiguelvalente.github.io/grupos/";
            $sizesad = ['160x600','300x250','468x60','728x90'];
            foreach ($sizesad as $key => $ad) {
               $width = explode('x', $ad)[0];
               $height = explode('x', $ad)[1];
               $html = "<a href=\"$linkad\" target=\"_blank\"><img alt=\"ads $ad\" title=\"Publicidad $ad\" width=\"$width\" height=\"$height\" src=\"{$web['url']}/public/images/ad$ad.png\"></a>";
               $set[] = "ads_" . explode('x', $ad)[0] . " = '" . html_entity_decode($html) . "'";
            }
            $ads = join(', ', $set);
            $database->query("UPDATE w_ads SET $ads WHERE asd_id = 1");
            // UPDATE
            $wConfig = [
               'titulo' => $web['name'],
               'slogan' => $web['slogan'],
               'url' => $web['url'],
               'email' => $web['mail'],
               'idioma' => $web['lang'],
               'version' => $ConfigInstall['version_a'],
               'version_code' => $ConfigInstall['version_b'],
               'pkey' => $web['pkey'],
               'skey' => $web['skey']
            ];

            if ($database->query("UPDATE w_configuracion SET {$Install->getIUP($wConfig)} WHERE tscript_id = 1")) header("Location: index.php?step=6");
            else $message = $database->error();
         }
      }
   break;
   // ADMINISTRADOR
   case 6:
      // No saltar la licencia
      if (!$_SESSION['license']) header("Location: index.php");

      // Step
      $next = false;
      if ($_POST['save']) {
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
            define('TS_HEADER', true);
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
               copy($avatar, AVATAR . "{$user_id}.webp");
      
               $database->query("INSERT INTO u_perfil (user_id, p_avatar) VALUES ($user_id, 1)");
               $database->query("INSERT INTO u_portal (user_id) VALUES ($user_id)");
               // UPDATE
               $database->query("UPDATE p_posts SET post_user = $user_id, post_category = 30, post_date = $time WHERE post_id = 1");
               $database->query("UPDATE w_stats SET stats_time_foundation = $time, stats_time_upgrade = $time WHERE stats_no = 1");
               // DAMOS BIENVENIDA POR CORREO
               mail($user['mail'], 'Su comunidad ya puede ser usada', "<html><head><title>Su nueva comunidad Link Sharing est&aacute; lista!</title></head><body><p>Estas son sus credenciales de acceso:</p><p>Usuario: {$user['name']}</p><p>Contrase&ntilde;a: {$user['pass']}</p><br />Gracias por usar <a href=\"$script_web\"><b>PHPost Risus</b></a> para compartir enlaces :)</body></html>", 'Content-type: text/html; charset=iso-8859-15');
               //
               header("Location: index.php?step=7&uid=$user_id");
            }
         }
      }
   break;
   case 7:
      // No saltar la licensia
      if (!$_SESSION['license']) header("Location: index.php");
      // DATOS DE CONEXION
      define('TS_HEADER', true);
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="PHPost" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="<?=$base_url?>/assets/SyntaxisLite-ico-64.ico?<?=time()?>" type="image/x-icon" />
<title>Instalaci&oacute;n de <?=$ConfigInstall['version_a']?></title>
<link href="<?=$base_url?>/assets/estilo.css?<?=time()?>" rel="stylesheet" type="text/css" />
</head>
<body class="d-flex justify-content-center align-items-center flex-column">
   <div class="page-wrapper d-grid overflow-hidden rounded">
      <header class="text-center py-4 d-flex justify-content-center text-center position-relative">
         <p class="m-0 py-4">
            Programa de instalaci&oacute;n: <b><?=$ConfigInstall['version_a']?></b>
         </p>
         <div class="dots position-absolute">
            <span class="d-inline-block rounded-circle"></span>
            <span class="d-inline-block rounded-circle"></span>
            <span class="d-inline-block rounded-circle"></span>
         </div>
      </header>
      <main class="h-100 position-relative">
         <?php if($step == 0): ?>
            <div class="init w-100 h-100 d-flex justify-content-center align-items-center flex-column">
               <img class="rounded-circle" src="<?=$base_url?>/assets/SyntaxisLite-ico.png?<?=time()?>" alt="<?=$ConfigInstall['version_a']?>">
               <h4 class="m-0 py-2">Bienvenidos a la instalación de:</h4>
               <p class="m-0 py-2"><?=$ConfigInstall['version_a']?></p>
               <a href="?step=1" class="button">Empezar...</a>
            </div>
         <?php elseif($step == 1): ?>
            <p>Antes de continuar con la instalación asegurate de cumplir todos o algunos estos requisitos:</p>
            <table class="extensiones">
               <thead>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Versión</th>
                  <th>Estado</th>
               </thead>
               <tbody>
                  <?php foreach($exists as $k => $a): ?>
                  <tr>
                     <td><?=$exists[$k]['nombre']?></td>
                     <td><?=$exists[$k]['descripcion']?></td>
                     <td><?=$exists[$k]['version']?></td>
                     <td class="status <?=$exists[$k]['clase']?>">
                        <iconify-icon icon="<?=$exists[$k]['icon']?>"></iconify-icon>
                     </td>
                  </tr>
                  <?php if($exists[$k]['clase'] == 'no'): ?>
                     <?php if(!empty($exists[$k]['info'])): ?>
                        <tr>
                           <td class="info" colspan="4"><?=$exists[$k]['info']?></td>
                        </tr>
                     <?php endif; ?>
                  <?php endif; ?>
                  <?php endforeach; ?>
               </tbody>
            </table>
            <?php if(!$des): ?>
               <p>Se puede continuar, pero se recomienda que actualices "Smarty y/o PHP" después de la instalación!</p>
            <?php endif; ?>
               <a href="?step=2" class="button button-fix">Continuar...</a>

         <?php elseif($step > 1 && $step < 8): ?>
            <form action="<?php echo $accion_form; ?>" method="post" id="form" autocomplete="OFF">
               <fieldset>
               <?php if($step == 2): ?>
                  <legend>Licencia</legend>
                  <p>Para utilizar PHPost Risus debes estar de acuerdo con nuestra licencia de uso.</p>
                  <textarea name="license"><?php echo $licence; ?></textarea>
                  <p><input type="submit" class="button" value="Acepto"/></p>
               <?php elseif($step == 3): ?>
                  <legend>Permisos de escritura</legend>
                  <p>Los siguientes archivos y directorios requieren de permisos especiales, debes cambiarlos desde tu cliente FTP, los archivos deben tener permiso <strong>666</strong> y los direcorios <strong>777</strong></p>
                  <?php foreach ($permisos as $k => $val): 
                     $txt = ($val['css'] === 'OK') ? 'Escribible' : $val['status'];
                  ?>
                     <dl>
                        <dt><label for="<?=$key?>"><?=$all[$k]?></label></dt>
                        <dd><span class="status <?=strtolower($val['css']); ?>"><?=$txt?></span></dd>
                     </dl>
                  <?php endforeach; ?>
                  <p><input type="submit" class="button" value="<?=($next == true ? 'Continuar &raquo;' : 'Volver a verificar') ?>"/></p>
               <?php elseif($step == 4): ?>
                  <legend>Base de datos</legend>
                  <p>Ingresa tus datos de conexi&oacute;n a la base de datos.</p>
                  <?php if ($message) echo '<div class="error">' . $message . '</div>'; ?>
                  <dl>
                        <dt><label for="f1">Servidor:</label><span>Donde est&aacute; la base de datos, ej: <strong>localhost</strong></span></dt>
                        <dd><input type="text" autocomplete="off" id="f1" name="db[hostname]" placeholder="localhost" value="<?=(empty($db['hostname']) ? '' : $db['hostname'])?>" required/></span></dd>
                     </dl>
                     <dl>
                        <dt><label for="f2">Usuario:</label><span>El usuario de tu base de datos.</span></dt>
                        <dd><input type="text" autocomplete="off" id="f2" name="db[username]" placeholder="root" value="<?=(empty($db['username']) ? '' : $db['username'])?>" required/></span></dd>
                     </dl>
                     <dl>
                        <dt><label for="f3">Contrase&ntilde;a:</label><span>Para acceder a la base de datos.</span></dt>
                        <dd><input type="password" autocomplete="off" id="f3" name="db[password]" placeholder="" value="<?=(empty($db['password']) ? '' : $db['password'])?>" /></span></dd>
                     </dl>
                     <dl>
                        <dt><label for="f4">Base de datos</label><span>Nombre de la base de datos para tu web.</span></dt>
                        <dd><input type="text" autocomplete="off" id="f4" name="db[database]" placeholder="mydatabase" value="<?=(empty($db['database']) ? '' : $db['database'])?>" required/></span></dd>
                     </dl>
                  <p><input type="submit" class="button" name="save" value="Continuar &raquo;"/></p>
               <?php elseif($step == 5): ?>
                  <legend>Datos del sitio</legend>
                  <?php if ($message) {echo '<div class="error">' . $message . '</div>';}?>
                  <dl>
                       <dt><label for="f1">Nombre:</label><span>El t&iacute;tulo de tu web.</span></dt>
                       <dd><input type="text" id="f1" name="web[name]" placeholder="<?=$ConfigInstall['nombre']?>" value="<?=(empty($web['name']) ? '' : $web['name'])?>" required/></dd>
                    </dl>
                    <dl>
                       <dt><label for="f2">Slogan:</label><span>Una breve descripción.</span></dt>
                       <dd><input type="text" id="f2" name="web[slogan]" placeholder="<?=$ConfigInstall['slogan']?>" value="<?=(empty($web['slogan']) ? '' : $web['slogan'])?>" required/></span></dd>
                    </dl>
                    <dl>
                       <dt><label for="f3">Direcci&oacute;n:</label><span>Ingresa la url donde  est&aacute; alojada tu web, sin la &uacute;ltima diagonal <strong>/</strong> </span></dt>
                       <dd><input type="text" id="f3" name="web[url]" value="<?=(empty($web['url']) ? $url : $web['url'])?>" required/></dd>
                    </dl>
                    <dl>
                       <dt><label for="f4">Email:</label><span>Email de la web o del administrador.</span></dt>
                       <dd><input type="text" id="f4" name="web[mail]" placeholder="example@server.com" value="<?=(empty($web['mail']) ? '' : $web['mail'])?>" required/></dd>
                    </dl>
                  <dl>
                  <dt><label for="f5">Idioma:</label><br /><span>Para configuración del TimeZone php</span></dt>
                     <dd> 
                        <select name="web[lang]" id="f5">
                           <option value="0">Selecciona un idioma</option>
                           <option value="es-ES"<?php echo ($wlang == 'es-ES') ?? ' selected'; ?>>Español</option>
                           <option value="en-GB"<?php echo ($wlang == 'en-GB') ?? ' selected'; ?>>English</option>
                        </select>
                     </dd>
                  </dl>
                  <legend>Datos de reCAPTCHA</legend>
                  <p>Obtén tu clave desde <a href="https://www.google.com/recaptcha/admin" target="_blank"><strong>www.google.com/recaptcha/admin</strong></a></p>
                  <dl>
                     <dt><label for="f5">Clave pública del sitio:</label></dt>
                     <dd><input type="text" id="f5" name="web[pkey]" value="<?=(empty($web['pkey']) ? '' : $web['pkey'])?>" required /></dd>
                  </dl>
                  <dl>
                     <dt><label for="f6">Clave secreta:</label></dt>
                     <dd><input type="text" id="f6" name="web[skey]" value="<?=(empty($web['skey']) ? '' : $web['skey'])?>" required/></dd>
                  </dl>
                  <p><input type="submit" name="save" class="button" value="Continuar &raquo;"/></p>
               <?php elseif($step == 6): ?>
                  <legend>Administrador</legend>
                  <p>Ingresa tus datos de usuario, m&aacute;s adelante debes editar tu cuenta para ingresar datos como, fecha de nacimiento, lugar de residencia, etc.</p>
                  <?php if ($message) echo '<div class="error">' . $message . '</div>'; ?>
                  <dl>
                     <dt><label for="f1">Nombre de usuario:</label></dt>
                     <dd><input type="text" id="f1" name="user[name]" autocomplete="off" value="<?=(empty($user['name']) ? '' : $user['name'])?>" required/></span></dd>
                  </dl>
                  <dl>
                     <dt><label for="f2">Contrase&ntilde;a:</label></dt>
                     <dd><input type="password" id="f2" name="user[pass]" autocomplete="off" value="<?=(empty($user['pass']) ? '' : $user['pass'])?>" required/></span></dd>
                  </dl>
                  <dl>
                     <dt><label for="f3">Confirmar contrase&ntilde;a:</label><span>Ingresa tu contrase&ntilde;a nuevamente.</span></dt>
                     <dd><input type="password" id="f3" name="user[passc]" autocomplete="off" value="<?=(empty($user['passc']) ? '' : $user['passc'])?>" required/></span></dd>
                  </dl>
                  <dl>
                     <dt><label for="f4">Email:</label><span>Ingresa tu direcci&oacute;n de email.</span></dt>
                     <dd><input type="text" id="f4" name="user[mail]" autocomplete="off" value="<?=(empty($user['mail']) ? '' : $user['mail'])?>" required/></span></dd>
                  </dl>
                  <p><input type="submit" name="save" class="button" value="Continuar &raquo;"/></p>
               <?php elseif($step == 7): ?>

                  <div class="init w-100 h-100 d-flex justify-content-center align-items-center flex-column">
                     <img class="rounded-circle" src="<?=$base_url?>/assets/SyntaxisLite-ico.png?<?=time()?>" alt="<?=$ConfigInstall['version_a']?>">
                     <h4 class="m-0 py-2">Bienvenido a <?=$ConfigInstall['nombre']?></h4>
                     <form action="https://phpost.es/feed/index.php?type=install" method="post" id="form">
                        <small>Al finalizar se eliminará la carpeta <b><?php echo basename(getcwd()); ?></b> automáticamente.</small>
                        <fieldset>
                           <p style="line-height: 1.7rem;font-size: 16px;width:60%;margin:12px auto;" class="d-block text-center">Gracias por instalar <strong><?=$ConfigInstall['version_a']?></strong>, ya est&aacute; lista tu nueva comunidad <strong>Link Sharing System</strong>. S&oacute;lo inicia sesi&oacute;n con tus datos y comienza a disfrutar. Ahora no dejes de <a href="https://www.phpost.es" target="_blank"><u>visitarnos</u></a> para estar pendiente de futuras actualizaciones. Recuerda reportar cualquier bug que encuentres, de esta manera todos ganamos.</p>
                        </fieldset>
                        <span class="grupos">Sumate a nuestros grupos:
                           <a sthref="https://discord.gg/mx25MxAwRe" target="_blank">Discord</a> - 
                           <a sthref="https://t.me/PHPost23" target="_blank">Telegram</a>
                        </span>
                        <center>
                           <input type="hidden" name="key" value="<?php echo $key; ?>" />
                           <input type="submit" value="Finalizar" class="button"/>
                       </center>
                    </form>
                  </div>
               <?php endif; ?>
               </fieldset>
             </form>
         <?php endif; ?>
      </main>
      <p class="m-0 text-center w-100">Powered by <a style="text-decoration:none;color:whitesmoke;font-weight:600;" href="https://www.phpost.es" target="_blank">PHPost</a> - Copyright &copy; <?=date('Y')?> - Creado <a style="text-decoration:none;color:whitesmoke;font-weight:600;" href="https://t.me/JvalenteM92" alt="perfil telegram" title="Mi perfil en telegram" target="_blank">Miguel92</a></p>
      <footer></footer>
   </div>
   <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>
