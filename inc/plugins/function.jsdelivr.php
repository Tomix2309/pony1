<?php 

/**
 * Smarty function
 *
 *
 * @param array $params 
 * @param Smarty_Internal_Template $smarty Instancia del objeto Smarty.
 * @return string Código HTML generado por la función.
*/

class jsdelivr {

	private $plugins = [
		'bootstrap' => [
			'page' => 'all',
			'version' => '5.3.2',
			'style' => 'dist/css/bootstrap.min.css'
		],
		'feather-icons' => [
			'page' => 'all',
			'version' => '4.29.1',
			'style' => ''
		],
		'iconify-icon' => [
			'page' => 'all',
			'version' => '1.0.8',
			'style' => ''
		],
		'driver.js' => [
			'page' => 'perfil',
			'version' => '1.3.1',
			'style' => 'dist/driver.min.css',
			'src' => '.js@1.0.1/dist/driver.js.iife.js'
		],
		'croppr' => [
			'page' => 'cuenta',
			'version' => '2.3.1',
			'style' => 'dist/croppr.min.css'
		],
		'vanilla-lazyload' => [
			'page' => 'all',
			'version' => '17.8.4',
			'style' => 'dist/vanilla-lazyload.min.css'
		]
	];

	private $urlCdn = 'https://cdn.jsdelivr.net/';

	public $livr = [];

	public function __construct() {
		$this->livr['plugins'] = $this->plugins;
	}

	private function getURL(bool $combine = false) {
		$getUrl = $this->urlCdn;
		if($combine) $getUrl .= 'combine/';
		return $getUrl;
	}

	public function joinSources(bool $combine = false, array $sources = []):string {
		$url = self::getURL($combine);
		return $url . join(',', $sources);
	}

}

function smarty_function_jsdelivr($params, &$smarty) {
	$jsdelivr = new jsdelivr;

	# Creamos la variable en la cual almacenaremos toda la info
	$sl2html = '';

	# Página
	$pagina = $smarty->tpl_vars['tsPage']->value;

	# Si es para los estilos
	if(in_array($params['type'], ['style', 'styles', 'css'])) {
		foreach($params['sources'] as $sid => $source) {
			$data = $jsdelivr->livr['plugins'][$source];
			if(!in_array($data['page'], ['perfil', 'cuenta', 'admin'])) {
				$array[$sid] = "npm/$source@{$data['version']}/{$data['style']}";
			} elseif($data['page'] == $pagina) {
				$array[$sid] = "npm/$source@{$data['version']}/{$data['style']}";
			}
		}
		if($array !== NULL) {
			$data = $jsdelivr->joinSources($params['combine'], $array);
			$sl2html = "<link rel=\"stylesheet\" href=\"$data\" />\n";
		}
	}
	
	if(in_array($params['type'], ['script', 'scripts', 'js', 'javascripts'])) {
		foreach($params['sources'] as $sid => $source) {
			$data = $jsdelivr->livr['plugins'][$source];
			$e = isset($data['src']) ? $data['src'] : '';
			if(!in_array($data['page'], ['perfil', 'cuenta', 'admin'])) {
				$array[$sid] = "npm/" . str_replace('.js', $e, $source);
			} elseif($data['page'] == $pagina) {
				$array[$sid] = "npm/" . str_replace('.js', $e, $source);
			}
		}
		if($array !== NULL) {
			$data = $jsdelivr->joinSources($params['combine'], $array);
			$sl2html = "<script src=\"$data\"></script>\n";
		}
	}

	return trim($sl2html);
}