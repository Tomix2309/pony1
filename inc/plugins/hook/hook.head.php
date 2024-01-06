<?php 

/**
 * @name hook.head.php
 * @version 2
*/

$lang = $params['lang'];
$url = $config['url'];
$title = $smarty->tpl_vars['tsTitle']->value;
$imagen = $smarty->tpl_vars['tsImagen']->value;

$device = [
	'width=device-width',
	'initial-scale=1',
	'shrink-to-fit=no'
];
$device = join(', ', $device);

$description = trim(strip_tags($smarty->tpl_vars['tsSeoDescripcion']->value));

$sl2html .= "<link rel=\"alternate\" hreflang=\"es-ES\" href=\"{$config['domain']}\"/>\n";
$sl2html .= "<link rel=\"canonical\" href=\"{$canonical}\" />\n";
$sl2html .= "<link rel=\"shortcut icon\" href=\"{$imagen}\" />\n";

$sl2html .= "<meta http-equiv=\"Content-Language\" content=\"$lang\" />\n";
$sl2html .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
$sl2html .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";

$name = [
	'author' => $author,
	'description' => $description,
	'keywords' => $smarty->tpl_vars['tsKey']->value,
	'publisher' => $author,
	'rating' => 'public',
	'robots' => 'index, follow',
	'title' => $title,
	'viewport' => $device,
	'job:site' => $smarty->tpl_vars['jobSite']->value
];
foreach($name as $t => $value) $sl2html .= "<meta name=\"$t\" content=\"$value\">\n";
if($params['meta'] === true) {
	$fb = [
		'og' => [
			'description' => $description,
			'image' => $imagen,
			'locale' => $lang,
			'site_name' => $config['titulo'],
			'title' => $title,
			'type' => 'website',
			'url' => $url
		],
		'article' => [
			'author' => $author,
			'published_time' => $smarty->tpl_vars['tsPublished']->value,
			'section' => 'website'
		]
	];
	if(!empty($smarty->tpl_vars['AppFb']->value)) {
		$fb['fb'] = ['app_id' => $smarty->tpl_vars['AppFb']->value];
	}
	$sl2html .= "<!-- Open Graph / Facebook -->\n";
	foreach($fb as $t => $value) {
		foreach ($value as $key => $content) {
			$sl2html .= "<meta property=\"$t:$key\" content=\"$content\">\n";
		}
	}

	$sl2html .= "<!-- Twitter -->\n";
	$twitter = [
		'card' => 'summary_large_image',
		'url' => $url,
		'title' => $title,
		'description' => $description,
		'image' => $imagen,
	];
	if(!empty($smarty->tpl_vars['TwUser']->value)) {
		$twitter['site'] = $smarty->tpl_vars['TwUser']->value;
	}
	foreach($twitter as $t => $value) $sl2html .= "<meta twitter=\"twitter:$t\" content=\"$value\">\n";
	$sl2html .= "<meta name=\"twitter:image:alt\" content=\"$title\">\n";
}