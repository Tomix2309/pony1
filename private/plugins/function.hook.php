<?php 

/**
 * Autor: Miguel92
 * Ejemplo: {hook css=['string|array'] js=['string|array'] global=boolean} 
 * Enlace: #
 * Fecha: Feb 28, 2024 
 * Nombre: hook
 * Proposito: Añadir css/js al sitio
 * Tipo: function 
 * Version: 1.0 
*/

class Hooker {

	private $theme;

	private $routes;

	private $directories;

	public $settings;

	public function __construct($smarty) {
		$config = $smarty->tpl_vars['tsConfig']->value;
		$this->settings['config'] = $config;
		$this->settings['user'] = $smarty->tpl_vars['tsUser']->value;
		$this->settings['nots'] = $smarty->tpl_vars['tsNots']->value;
		$this->settings['mps'] = $smarty->tpl_vars['tsMPs']->value;
		$this->settings['action'] = $smarty->tpl_vars['tsAction']->value;

		$this->settings['post'] = $smarty->tpl_vars['tsPost']->value;
		$this->settings['foto'] = $smarty->tpl_vars['tsFoto']->value;

		$this->settings['live'] = $config['c_allow_live'];
		//
		$this->routes = [
			'theme' => [
				'tema' => $config['tema']['t_url'] . '/',
				'css' => $config['css'] . '/',
				'js' => $config['js'] . '/'
			],
			'assets' => [
				'wysibb' => $config['assets'] . '/wysibb/',
				'css' => $config['assets'] . '/css/',
				'js' => $config['assets'] . '/js/'
			]
		];
		$this->directories = [
			'theme' => [
				'tema' => $smarty->template_dir["tema"],
				'css' => $smarty->template_dir["tema"] . "css" . SEPARATOR,
				'js' => $smarty->template_dir["tema"] . "js" . SEPARATOR
			],
			'assets' => [
				'wysibb' => $smarty->template_dir["assets"] . "wysibb" . SEPARATOR,
				'css' => $smarty->template_dir["assets"] . "css" . SEPARATOR,
				'js' => $smarty->template_dir["assets"] . "js" . SEPARATOR
			]
		];
	}

	public function PermisoEspecial() {
		$tsUser = $this->settings['user'];
		return ($tsUser->is_admod OR $tsUser->permisos['moacp'] OR $tsUser->permisos['most'] OR $tsUser->permisos['moayca'] OR $tsUser->permisos['mosu'] OR $tsUser->permisos['modu'] OR $tsUser->permisos['moep'] OR $tsUser->permisos['moop'] OR $tsUser->permisos['moedcopo'] OR $tsUser->permisos['moaydcp'] OR $tsUser->permisos['moecp']);
	}

	private function Integrity(string $file = ''):string {
		$file_content = file_get_contents($file);
		$hash = base64_encode(hash('sha256', $file_content, true));
		return "integrity=\"sha256-$hash\" crossorigin=\"anonymous\"";
	}

	/**
	 * @access private
    * Genera una etiqueta HTML para un recurso (CSS o JS) desde JSDelivr.
    * 
    * @param string $file La ruta del recurso
    * @return string La etiqueta HTML generada.
   */
	private function generateHtmlTag(string $file = ''):string {
		$typeTag = pathinfo($file, PATHINFO_EXTENSION);
		$integrity = self::Integrity($file);
		$file .= '?' . uniqid('SL2');
		if($typeTag == 'css') {
			return "<link rel=\"stylesheet\" href=\"$file\" $integrity/>\n";
		} else {
			return "<script src=\"$file\" $integrity></script>\n";
		}
	}

	private function fileExists(mixed $file = '', string $folder = '') {
		$searchIn = ['assets', 'theme'];
		foreach($searchIn as $search):
			if(file_exists($this->directories[$search][$folder] . $file)) {
				$data = self::generateHtmlTag($this->routes[$search][$folder].$file);
			}
			if($search == 'theme') {
				if(file_exists($this->directories['theme']['tema'] . $file)) {
					$data = self::generateHtmlTag($this->routes['theme']['tema'].$file);
				}
			}
			if($file == 'wysibb.css' OR $file == 'wysibb.js') {
				$data = self::generateHtmlTag($this->routes['assets']['wysibb'].$file);
			}
		endforeach;
		return $data;
	}

	public function StyleSheet(mixed $filecss = '', string $addpagecss = '') {
		$html = '';
		# Primero verificamos si existe el archivo
		if(is_array($filecss)) {
			foreach($filecss as $file) $html .= self::fileExists($file, 'css');
		} else $html .= self::fileExists($filecss, 'css');
		$html .= self::fileExists("$addpagecss.css", 'css');
		return $html;
	}

	public function Scripts(mixed $filescript = '', string $addpagescript = '') {
		$html = '';
		# Primero verificamos si existe el archivo
		if(is_array($filescript)) {
			foreach($filescript as $file) $html .= self::fileExists($file, 'js');
		} else $html .= self::fileExists($filescript, 'js');
		$html .= self::fileExists("$addpagescript.js", 'js');
		return $html;
	}

}

function smarty_function_hook($params, &$smarty) {

	$Hooker = new Hooker($smarty);

	$pagina = $smarty->tpl_vars['tsPage']->value;
	$sl2html = "";

	$paginas_editor = ['posts', 'ver', 'agregar', 'files'];
	$agregar_editor = in_array($pagina, $paginas_editor) AND $params['wysibb'];

	if(is_array($params['css']) OR is_string($params['css'])) {
		if($params['position'] == 'start') {
			$append = $pagina;
			// Añadimos el editor wysibb si coincide con estas páginas
			if($agregar_editor) array_push($params['css'], 'wysibb.css');
		} else $append = '';
		$sl2html .= $Hooker->StyleSheet($params['css'], $append);
	}

	if(is_array($params['js']) OR is_string($params['js'])) {
		if($params['position'] == 'start' OR $params['position'] == 'login') {
			$append = $pagina;
			if($params['position'] == 'start') {
				array_unshift($params['js'], 'jquery.plugins.js');
			}
			// Añadimos 'moderacion.js' solo si tiene permisos especiales
			if($Hooker->PermisoEspecial()) {
				array_push($params['js'], 'moderacion.js');
			}
			// Añadimos 'live.js'
			if((int)$Hooker->settings['live'] AND $Hooker->settings['nots'] > 0 OR $Hooker->settings['mps'] > 0 AND $Hooker->settings['action'] != 'leer') {
				array_push($params['js'], 'live.js');
			}
			// Añadimos el editor wysibb si coincide con estas páginas
			if($agregar_editor) array_push($params['js'], 'wysibb.js');
		} else $append = '';
		$sl2html .= $Hooker->Scripts($params['js'], $append);
	}

	if($params['global']) {
		if($Hooker->settings['user']->uid != 0) {
			$d['user_key'] = (int)$Hooker->settings['user']->uid;
		}
		if(is_numeric($Hooker->settings['post']['post_id']) AND $pagina === 'posts') {
			$d['postid'] = (int)$Hooker->settings['post']['post_id'];
		}
		if(is_numeric($Hooker->settings['foto']['foto_id']) AND $pagina === 'fotos') {
			$d['fotoid'] = (int)$Hooker->settings['foto']['foto_id'];
		}
		if($Hooker->settings['user']->is_member) $d['avatar'] = $Hooker->settings['user']->avatar;
		// Siempre
		$d['tema'] = "{$Hooker->settings['config']['tema']['t_url']}/";
		$d['images'] = "{$Hooker->settings['config']['images']}/";
		$d['url'] = $Hooker->settings['config']['url'];
		$d['domain'] = $Hooker->settings['config']['domain'];
		$d['titulo'] = $Hooker->settings['config']['titulo'];
		$d['slogan'] = $Hooker->settings['config']['slogan'];
		$d['page'] = $pagina;
		$d['logueado'] = ($Hooker->settings['user']->is_member) ? 'si' : 'no';
		ksort($d);

		foreach($d as $name => $val) $global[] = "\t$name: " .(is_numeric($val) ? $val : "'$val'");
		$global_data = join(",\n", $global);
		$sl2html .= <<< SL2Global
		<script>
		const global_data = {\n$global_data\n}
		$(document).ready(() => {
			notifica.popup({$tsNots});
			mensaje.popup({$tsMPs});
		});
		</script>
		SL2Global;
	}

	return trim($sl2html);
}

/*function smarty_function_hook($params, &$smarty) {
	global $seo, $tsPost, $tsFoto;
	# Creamos la variable en la cual almacenaremos toda la info
	$sl2html = '';
	$author = 'Miguel92';

	$config = $smarty->tpl_vars['tsConfig']->value;
	$pagew = $smarty->tpl_vars['tsPage']->value;
	//
	$tsNots = $smarty->tpl_vars['tsNots']->value;
	$tsMPs = $smarty->tpl_vars['tsMPs']->value;
	$tsAction = $smarty->tpl_vars['tsAction']->value;

	$params['meta'] = (isset($params['meta']) AND $params['meta'] === true) ? true : $params['meta'];

	# Separamos los hooks por carpeta
	if($params['name'] === 'head' OR $params['name'] === 'header'):
		include ROUTEPLUGINS . 'hook' . SEPARATOR . 'hook.css.php';
		include ROUTEPLUGINS . 'hook' . SEPARATOR . 'hook.js.php';

		if($params['wysibb'] === true) {
			if(in_array($pagew, ['posts', 'ver', 'agregar', 'files'])) {
				$sl2html .= "<script src=\"{$config['tema']['t_url']}/wysibb/wysibb.js?$time\"></script>\n";
				$sl2html .= "<link rel=\"stylesheet\" href=\"{$config['tema']['t_url']}/wysibb/wysibb.css?$time\" />\n";
			}
		}

		if($config['c_allow_live']) {
			if($tsNots > 0 || $tsMPs > 0 && $tsAction != 'leer') {
				$sl2html .= "<script src=\"{$config['js']}/live.js?$time\"></script>\n";
			}
		}

	endif;

	if($params['name'] === 'global') {
		$user = new tsUser;
		//$foto = new tsFotos;
		if(isset($user->info['user_id'])) $gbl['user_key'] = (int)$user->info['user_id'];
		if(is_numeric($tsPost['post_id']) AND $pagew === 'posts') (int)$gbl['postid'] = $tsPost['post_id'];
		if(is_numeric($tsFoto['foto_id']) AND $pagew === 'fotos') (int)$gbl['fotoid'] = $tsPost['foto_id'];
		if($user->is_member) $gbl['avatar'] = $user->avatar;
		// Siempre
		$gbl['img'] = "{$config['tema']['t_url']}/";
		$gbl['url'] = $config['url'];
		$gbl['domain'] = $config['domain'];
		$gbl['s_title'] = $config['titulo'];
		$gbl['s_slogan'] = $config['slogan'];
		$gbl['page'] = $pagew;
		$gbl['logueado'] = ($user->is_member) ? 'si' : 'no';
		//
		ksort($gbl);
		foreach($gbl as $name => $val) $globalthis[] = "\t\t$name: " .(is_numeric($val) ? $val : "'$val'");
		$global_data = join(",\n", $globalthis);
		$sl2html = <<< SyntaxisLiteGlobal
		<script>
			const global_data = {\n$global_data\n\t}
			$(document).ready(() => {
				notifica.popup({$tsNots});
				mensaje.popup({$tsMPs});
			});
		</script>
		SyntaxisLiteGlobal;
	}

	if($params['name'] === 'footer'):
		include ROUTEPLUGINS . 'hook' . SEPARATOR . 'hook.js.php';
	endif;

	return trim($sl2html);
}*/