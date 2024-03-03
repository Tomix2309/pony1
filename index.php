<?php
/**
 * Resuelve para la home
 *
 * @name    index.php
 * 
 * @copyright SyntaxisLite v3 - 2024
 * @author Miguel92
 */

// Incluimos header
require_once realpath(__DIR__) . DIRECTORY_SEPARATOR . 'header.php';

// Checamos...
if($tsCore->settings['c_allow_portal'] == 1 && $tsUser->is_member && $_GET['do'] == 'portal'):
	require_once ROUTEPHP . 'portal.php';

else:
	# Home
	require_once ROUTEPHP . 'posts.php';

endif;