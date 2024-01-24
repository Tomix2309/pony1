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
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.fonts.php';
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.css.php';
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.js.php';

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
		include TS_PLUGINS . 'hook' . SEPARATOR . 'hook.js.php';
	endif;

	return trim($sl2html);
}