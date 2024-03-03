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

function smarty_function_image($params, &$smarty) {
	$tsCore = new tsCore;

	$_withoutcover = 'imagen_no_disponible.webp';
	$src = $params['src'];
	
	foreach (['files', 'images'] as $key => $carpeta) {
		if(file_exists(ROUTEFILES . $_withoutcover)) {
			$sinportada = $tsCore->settings[$carpeta] . '/' . $_withoutcover;
		} elseif(ROUTETHEMEACTIVE . 'images' . SEPARATOR . $_withoutcover) {
			$sinportada = $tsCore->settings['images'] . '/' . $_withoutcover;
		}
	}

	$parametros = [
		'alt' => "{$tsCore->settings['titulo']} {$tsCore->settings['slogan']}",
		'attr' => [
			'src' => $sinportada,
			'data-src' => $src
		],
		'class' => 'image lazy' . (!empty($params['class']) ? ' ' . $params['class'] : ''),
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