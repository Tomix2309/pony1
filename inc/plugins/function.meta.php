<?php 

/**
 * Smarty plugin para incluir archivos CSS y JS de forma independiente.
 *
 * Uso: Solo require el nombre del archivo
 *  {meta facebook=true twitter=false} 
 *
 * @param array $params Parámetros pasados a la función (en este caso, 'facebook|twitter').
 * @param Smarty_Internal_Template $smarty Instancia del objeto Smarty.
 * @return string Código HTML generado por la función.
*/



function smarty_function_meta($params, &$smarty) {
	global $tsCore, $tsPost, $tsFoto;

	$json = new tsJson;
	$json = $json->getSeo();
		// 
	$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
	$dominio = $_SERVER['HTTP_HOST'];
	$ruta = $_SERVER['REQUEST_URI'];
	# Armamos la url
	$url = $protocolo . "://" . $dominio . $ruta;
	# Titulo
	$title = (is_numeric($tsPost['post_id'])) ? $tsPost['post_title'] : ($tsFoto['foto_id'] ? $tsFoto['f_title'] : $json['titulo']);
	# Descripción
	$description = (is_numeric($tsPost['post_id'])) ? $tsPost['post_body_descripcion'] : ($tsFoto['foto_id'] ? $tsFoto['foto_descripcion'] : $json['descripcion']);
	# Etiquetas | tags
	$keywords = strtolower((is_numeric($tsPost['post_id'])) ? join(',', $tsPost['post_tags']) : $json['keywords']);
	# Portada
	if(isset($tsPost['post_portada']) AND empty($tsPost['post_portada'])) {
		$tsPost['post_portada'] = "{$tsCore->settings['files']}/portada.png";
	} 
	$image = (is_numeric($tsPost['post_id'])) ? $tsPost['post_portada'] : ($tsFoto['foto_id'] ? $tsFoto['foto_url'] : $json['portada']);
	// Tipo
	$type = is_numeric($tsPost['post_id']) ? 'article' : 'website';
	//
	$nameRobots = [
		0 => 'robots', 
		1 => 'googlebot', 
		2 => 'googlebot-news'
	];
	$contentRobots = [
		0 => 'index', 
		1 => 'follow', 
		2 => 'noindex', 
		3 => 'nofollow', 
		4 => 'nosnippet', 
		5 => 'index, follow', 
		6 => 'index, nofollow', 
		7 => 'noindex, follow', 
		8 => 'noindex, nofollow'
	];
	# Creamos las etiquetas
	$sl2html = "<!-- Meta Tags Generado por {$tsCore->settings['url']} -->\n";
	$tags = ['title', 'description', 'keywords'];
	// Etiquetas por defecto
	foreach ($tags as $tag) $sl2html .= "<meta name=\"$tag\" content=\"".$$tag."\" />\n";
	$sl2html .= "<meta name=\"application-name\" content=\"{$json['titulo']}\">\n";
	$sl2html .= "<meta name=\"msapplication-TileImage\" content=\"{$json['favicon']}\">\n";
	$sl2html .= "<meta name=\"msapplication-TileColor\" content=\"{$json['color']}\">\n";
	$sl2html .= "<meta name=\"theme-color\" media=\"(prefers-color-scheme: light)\" content=\"#5599DE\">\n";
	$sl2html .= "<meta name=\"theme-color\" media=\"(prefers-color-scheme: dark)\"  content=\"#343232\">\n";

	# Robots | Rastreadores
	if((int)$json['robots']) {
		$name = $nameRobots[$json['robots_data']['name']];
		$content = $contentRobots[$json['robots_data']['content']];
		$sl2html .= "<meta name=\"$name\" content=\"$content\" />\n";
	}
	# Sitemap del sitio
	if((int)$json['sitemap']) {
		$sl2html .= "<link rel=\"sitemap\" type=\"application/xml\" title=\"Mapa del sitio\" href=\"{$tsCore->settings['url']}/sitemap.xml\">\n";
	}
	# Redes sociales
	$card = 'summary_large_image';
	$redes = [
		'facebook' => [
			'attr' => 'name',
			'prop' => 'og',
			'data' => ['type', 'url', 'title', 'description', 'image'],
		],
		'twitter' => [
			'attr' => 'property',
			'prop' => 'twitter',
			'data' => ['card', 'url', 'title', 'description', 'image'],
		]
	];
	foreach ($redes as $i => $social) {
		$sl2html .= "<!-- ".ucfirst($i)." -->\n";
		foreach ($social['data'] as $d => $info) {
			$sl2html .= "<meta {$social['attr']}=\"{$social['prop']}:$info\" content=\"".$$info."\" />\n";
		}
	}
	$type = pathinfo($json['favicon'])['extension'];
	$json['favicon'] .= '?t=' . time();
	$sl2html .= "<link href=\"{$json['favicon']}\" rel=\"shortcut icon\" type=\"image/$type\" />\n";
	foreach($json['images'] as $im => $img) {
		if(!empty($img)) {
			$img .= '?t=' . time();
			$sl2html .= "<link href=\"$img\" rel=\"shortcut icon\" type=\"image/$type\" sizes=\"{$im}x{$im}\" />\n";
		}
	}
	$langs = ['es', 'x-default'];
	foreach($langs as $lg) $sl2html .= "<link href=\"{$tsCore->settings['url']}\" rel=\"alternate\" hreflang=\"$lg\" />\n";
	//
	return trim($sl2html);
}