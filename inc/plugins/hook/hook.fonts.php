<?php 

if(is_array($params['fonts'])) {
	foreach ($params['fonts'] as $key => $font) {
		$myFont[$key] = "family=$font";
	}
	$addFont = join('&', $myFont);
} else $addFont = "family={$params['fonts']}";

$sl2html .= "<!-- GOOGLE FONTS -->\n";
$sl2html .= "<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\n";
$sl2html .= "<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\n";
$sl2html .= "<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css2?$addFont&display=swap\">\n";