<?php 

/**
 * Smarty function
 *
 *
 * @param array $params 
 * @param Smarty_Internal_Template $smarty Instancia del objeto Smarty.
 * @return string Código HTML generado por la función.
*/

function smarty_function_hook($params, &$smarty) {
	global $seo;
	# Creamos la variable en la cual almacenaremos toda la info
	$sl2html = '';
	$author = 'Miguel92';

	$config = $smarty->tpl_vars['tsConfig']->value;
	$canonical = $smarty->tpl_vars['canonical']->value;

	$params['meta'] = (isset($params['meta']) AND $params['meta'] === true) ? true : $params['meta'];

	# Separamos los hooks por carpeta
	if($params['name'] === 'head' OR $params['name'] === 'header'):
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.head.php';
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.fonts.php';
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.css.php';
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.js.php';

		if($params['wysibb'] === true) {
			$pagew = $smarty->tpl_vars['tsPage']->value;
			if(in_array($pagew, ['posts', 'ver', 'agregar'])) {
				$sl2html .= "<script src=\"{$config['tema']['t_url']}/wysibb/wysibb.js?$time\"></script>\n";
				$sl2html .= "<link rel=\"stylesheet\" href=\"{$config['tema']['t_url']}/wysibb/wysibb.css?$time\" />\n";
			}
		}

		if($config['c_allow_live']) {
			$tsNots = $smarty->tpl_vars['tsNots']->value;
			$tsMPs = $smarty->tpl_vars['tsMPs']->value;
			$tsAction = $smarty->tpl_vars['tsAction']->value;
			if($tsNots > 0 || $tsMPs > 0 && $tsAction != 'leer') {
				$sl2html .= "<script src=\"{$config['js']}/live.js?$time\"></script>\n";
			}
		}

	endif;

	if($params['name'] === 'footer'):
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.js.php';
	endif;

	return trim($sl2html);
}