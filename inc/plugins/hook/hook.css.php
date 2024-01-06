<?php 

$myTheme = $smarty->template_dir['tema'];
$myFolderCSS = $smarty->template_dir['css'];
$myRoute = $config['tema']['t_url'];
$myRouteCSS = $config['css'];

$time = time();

foreach($params['css'] as $k => $style) {
	if(file_exists($myTheme.$style)) {
		$sl2html .= "<link rel=\"stylesheet\" href=\"$myRoute/$style?$time\" />\n";
	} elseif(file_exists($myFolderCSS.$style)) {
		$sl2html .= "<link rel=\"stylesheet\" href=\"$myRouteCSS/$style?$time\" />\n";
	} else {
		$pagew = $smarty->tpl_vars['tsPage']->value;
		$dir = $smarty->template_dir[$pagew];
		if(file_exists($dir.$style)) {
			$sl2html .= "<link rel=\"stylesheet\" href=\"{$config['url']}/$pagew/$style?$time\" />\n";
		}
	}
}