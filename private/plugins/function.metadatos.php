<?php 

/**
 * Smarty plugin para incluir archivos CSS y JS de forma independiente.
 *
 * Uso: Solo require el nombre del archivo
 *  {metatags facebook=true twitter=true robots=true sitemap=true lang='es'}
 *
 * @param array $params Parámetros pasados a la función (en este caso, 'facebook|twitter').
 * @param Smarty_Internal_Template $smarty Instancia del objeto Smarty.
 * @return string Código HTML generado por la función.
*/

function verifyParams(mixed $param = '') {
	return isset($param) ? $param : false;
}

function smarty_function_metadatos($params, &$smarty) {
	global $tsCore, $tsPost, $tsFoto;

	$parametros = ['facebook', 'twitter', 'robots', 'sitemap'];
	foreach($parametros as $p)  $status[$p] = verifyParams($params[$p]);
	$params['lang'] = verifyParams($params['lang']) ? $params['lang'] : 'es';

	$url = $tsCore->getProtocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	$datos_seo = $tsCore->getSettingsSeo();

	# Titulo
	$title = (is_numeric($tsPost['post_id'])) ? $tsPost['post_title'] : ($tsFoto['foto_id'] ? $tsFoto['f_title'] : $datos_seo['seo_titulo']);

	# Descripción
	$description = (is_numeric($tsPost['post_id'])) ? $tsPost['post_body_descripcion'] : ($tsFoto['foto_id'] ? $tsFoto['foto_descripcion'] : $datos_seo['seo_descripcion']);

	# Etiquetas | tags
	$keywords = strtolower((is_numeric($tsPost['post_id'])) ? join(',', $tsPost['post_tags']) : $datos_seo['seo_keywords']);

	# Portada
	if(isset($tsPost['post_portada']) AND empty($tsPost['post_portada'])) {
		$tsPost['post_portada'] = "{$tsCore->settings['files']}/portada.png";
	} 
	$image = (is_numeric($tsPost['post_id'])) ? $tsPost['post_portada'] : ($tsFoto['foto_id'] ? $tsFoto['foto_url'] : $datos_seo['seo_portada']);
	
	# Tipo
	$type = is_numeric($tsPost['post_id']) ? 'article' : 'website';

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
	$sl2html = "<!-- Meta Tags Generado con MetaTags Plugins v2 creado por Miguel92 -->\n";

	$tags = ['title', 'description', 'keywords'];
	// Etiquetas por defecto
	foreach ($tags as $tag) $sl2html .= "<meta name=\"$tag\" content=\"".$$tag."\" />\n";

	$sl2html .= <<<SEOMETATAGP1
	<meta name="application-name" content="{$datos_seo['seo_titulo']}">
	<meta name="msapplication-TileColor" content="{$datos_seo['seo_color']}">
	<meta name="msapplication-TileImage" content="{$datos_seo['seo_favicon']}">
	<meta name="theme-color" media="(prefers-color-scheme: dark)"  content="#343232">
	<meta name="theme-color" media="(prefers-color-scheme: light)" content="#5599DE">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">\n
	SEOMETATAGP1;

	# Robots | Rastreadores
	if((int)$datos_seo['seo_robots'] AND $status['robots']) {
		$sl2html .= "<!-- Robots -->\n";
		$name = $nameRobots[$datos_seo['seo_robots_name']];
		$content = $contentRobots[$datos_seo['seo_robots_content']];
		$sl2html .= "<meta name=\"$name\" content=\"$content\" />\n";
	}

	# Sitemap del sitio
	if($status['sitemap']) {
		$sl2html .= "<!-- Sitemap -->\n";
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

		if($params[$i]) {
			$sl2html .= "<!-- ".ucfirst($i)." -->\n";
			foreach ($social['data'] as $d => $info) {
				$sl2html .= "<meta {$social['attr']}=\"{$social['prop']}:$info\" content=\"".$$info."\" />\n";
			}
		}
	}

	foreach($datos_seo['seo_imagenes'] as $sizeImage => $favicon) {
		if(!empty($favicon)) {
			$type = pathinfo($favicon, PATHINFO_EXTENSION);
			$favicon .= '?t=' . uniqid('fav');
			$sl2html .= "<link href=\"$favicon\" rel=\"shortcut icon\" type=\"image/$type\" sizes=\"{$sizeImage}x{$sizeImage}\" />\n";
		}
	}

	$type = pathinfo($datos_seo['seo_favicon'], PATHINFO_EXTENSION);
	$favicon = $datos_seo['seo_favicon'] . '?t=' . uniqid('fav');
	$sl2html .= "<link href=\"$favicon\" rel=\"shortcut icon\" type=\"image/$type\" />\n";

	# Idioma
	$sl2html .= "<link href=\"{$tsCore->settings['url']}\" rel=\"alternate\" hreflang=\"{$params['lang']}\" />\n";

	return trim($sl2html);
}