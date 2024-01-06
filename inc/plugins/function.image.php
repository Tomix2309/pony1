<?php 

/**
 * Smarty plugin para incluir archivos CSS y JS de forma independiente.
 *
 * Uso: Solo require el nombre del archivo
 *  {image type='post|portada' src='' class='opcional' alt='opcional'} 
 *
 * @param array $params 
 * @param Smarty_Internal_Template $smarty Instancia del objeto Smarty.
 * @return string Código HTML generado por la función.
*/

function fileExists(string $carpeta = '', string $portada = ''):string {
	global $tsCore;
	return $tsCore->settings[$carpeta] . "/$portada";
}

function smarty_function_image($params, &$smarty) {
	global $tsCore;

	$sinportada = 'SyntaxisLite-ico.png';
	$src = $params['src'];
	
	$fol = ['files', 'images'];
	foreach ($fol as $key => $carpeta) {
		if($carpeta == 'files') {
			if(file_exists(TS_FILES . $sinportada)) $sinportada = fileExists($carpeta, $sinportada);
		} else {
			if(file_exists(TS_TEMA_ACT . 'images' . SEPARATOR . $sinportada)) {
				$sinportada = fileExists($carpeta, $sinportada);
			}
		}
	}

	$parametros = [
		'alt' => "{$tsCore->settings['titulo']} {$tsCore->settings['slogan']}",
		'attr' => [
			'src' => $sinportada,
			'data-src' => $src,
			"srcset" => "$src 320w, $src 480w, $src 800w", 
			"sizes" => "(max-width: 320px) 280px, (max-width: 480px) 440px, 800px"
		],
		'class' => 'image lazy ' . $params['class'],
		'style' => $params['style']
	];

	# Verificamos si esta en la carpeta o es url
	$filtrar = filter_var($parametros['attr']['data-src'], FILTER_VALIDATE_URL);
	// Intenta obtener información sobre la imagen
   $imageInfo = getimagesize($src);
	if(in_array($params['type'], ['post', 'portada'])):
		//if( $filtrar ):
		if(empty($params['src']) OR !is_array($imageInfo)) {
			$parametros['attr']['data-src'] = $sinportada;
			$parametros['attr']['srcset'] = "{$parametros['attr']['data-src']} 320w, {$parametros['attr']['data-src']} 480w, {$parametros['attr']['data-src']} 800w";
		}
	endif;

	$parametros['alt'] = isset($params['alt']) ? $params['alt'] : $parametros['alt'];
	// Unimos los atributos
	foreach ($parametros['attr'] as $key => $attr) $parametros['attr'][$key] = "$key=\"$attr\"";
	$unir_parametros = join(' ', $parametros['attr']);
	// Unimos los otros atributos
	foreach ($parametros as $key => $pAttr)
		if($key !== 'attr' AND !empty($pAttr)) {
			$attrs[$key] = "$key=\"$pAttr\"";
		}
	$unir_attr = join(' ', $attrs);
	
	if($params['onclick'] === true):
		$filtrar = filter_var($params['href'], FILTER_VALIDATE_URL);
		$unir_attr .= ' onclick="' .($filtrar ? 'location.href=\''.$params["href"].'\'' : $params['href']). '"';
	endif;

	$image = "<img loading=\"lazy\" $unir_attr $unir_parametros>";

	return $image;
}