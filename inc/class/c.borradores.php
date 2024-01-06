<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Modelo para el control de los borradores
 *
 * @name    c.borradores.php
 * @author  PHPost Team
 */
class tsDrafts {

	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*\
								BORRADORES
	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/*
		newDraft()
	*/
	function newDraft($save = false){
		global $tsCore, $tsUser;
		//
		$draftData = array(
			'date' => time(),
			'title' => $tsCore->setSecure($tsCore->parseBadWords($_POST['titulo']), true),
			'portada' => $tsCore->setSecure($_POST['imagen'], true),
			'body' => $tsCore->setSecure($_POST['cuerpo'], true),
			'tags' => $tsCore->setSecure($tsCore->parseBadWords($_POST['tags']), true),
			'category' => $tsCore->setSecure($_POST['categoria']),
			'private' => empty($_POST['privado']) ? 0 : 1,
			'block_comments' => empty($_POST['sin_comentarios']) ? 0 : 1,
			'sponsored' => empty($_POST['patrocinado']) ? 0 : 1,
            'sticky' => empty($_POST['sticky']) ? 0 : 1,
			'smileys' => empty($_POST['smileys']) ? 0 : 1,
			'visitantes' => empty($_POST['visitantes']) ? 0 : 1,
		);
		//
		if(!empty($draftData['title'])) {
			if(!empty($draftData['category']) && $draftData['category'] > 0) {
			if($save) {
				// UPDATE
				$bid = intval($_POST['borrador_id']);
				$updates = $tsCore->getIUP($draftData, 'b_');
				//
                if(db_exec(array(__FILE__, __LINE__), 'query', 'UPDATE `p_borradores` SET '.$updates.' WHERE bid = \''.(int)$bid.'\' AND b_user = \''.$tsUser->info['user_id'].'\'')) return '1: '.$bid;
				else return '0: '.show_error('Error al ejecutar la consulta de la l&iacute;nea '.__LINE__.' de '.__FILE__.'.', 'db');
		   } else {
				// INSERT
			    if(db_exec(array(__FILE__, __LINE__), 'query', 'INSERT INTO `p_borradores` (`b_user`, `b_date`, `b_title`, `b_portada`, `b_body`, `b_tags`, `b_category`, `b_private`, `b_block_comments`, `b_sponsored`, `b_sticky`, `b_smileys`, `b_visitantes`, `b_status`, `b_causa`) VALUES (\''.$tsUser->info['user_id'].'\', \''.$draftData['date'].'\', \''.$draftData['title'].'\', \''.$draftData['portada'].'\', \''.$draftData['body'].'\', \''.$draftData['tags'].'\', \''.$draftData['category'].'\', \''.$draftData['private'].'\', \''.$draftData['block_comments'].'\', \''.$draftData['sponsored'].'\', \''.$draftData['sticky'].'\', \''.$draftData['smileys'].'\', \''.$draftData['visitantes'].'\', \'1\', \'\')')) return '1: '.db_exec('insert_id');
			   else return '0: '.show_error('Error al ejecutar la consulta de la l&iacute;nea '.__LINE__.' de '.__FILE__.'.', 'db');
			}
			} else $return = 'Categor&iacute;a';
		} else $return = 'T&iacute;tulos';
		//
		return '0: El campo <b>'.$return.'</b> es requerido para esta operaci&oacute;n';
		//
	}
	/*
		getDrafts()
	*/
	function getDrafts(){
		global $tsCore, $tsUser;
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT c.c_nombre, c.c_seo, b.bid, b.b_user, b.b_title, b.b_date, b.b_status, b.b_causa, b_body, b_portada, u.user_name FROM p_categorias AS c LEFT JOIN p_borradores AS b ON c.cid = b.b_category LEFT JOIN u_miembros AS u ON b.b_user = u.user_id WHERE b.b_user = \''.$tsUser->info['user_id'].'\' ORDER BY b.b_date');
		//
      $drafts['data'] = result_array($query);
      foreach ($drafts['data'] as $id => $row) {
         $drafts['data'][$id]['post_cover'] = $tsCore->extraer_img($drafts['data'][$id]['b_body']);
      }
      $drafts['total_cat'] = db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(b.b_category) AS total FROM p_borradores AS b '));

		return $drafts;
	}
	/*
		getDraft()
	*/
	function getDraft($status = 1){
		global $tsCore, $tsUser;
		//
		$bid = intval($_GET['action']);
        $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT bid, b_user, b_date, b_title, b_portada, b_body, b_tags, b_category, b_private, b_block_comments, b_sponsored, b_sticky, b_smileys, b_post_id, b_status, b_causa FROM `p_borradores` WHERE `bid` = \''.(int)$bid.'\' AND `b_user` = \''.$tsUser->info['user_id'].'\' AND b_status = \''.$status.'\' LIMIT 1');
		//
		return db_exec('fetch_assoc', $query);
	}
	/*
		delDraft()
	*/
	function delDraft(){
		global $tsCore, $tsUser;
		//
		$bid = intval($_POST['borrador_id']);
        if(db_exec(array(__FILE__, __LINE__), 'query', 'DELETE FROM `p_borradores` WHERE `bid` = \''.(int)$bid.'\' AND `b_user` = \''.$tsUser->info['user_id'].'\'')) return '1: Borrador eliminado';
		else return '0: Ocurri&oacute; un error';
	}

	
	
}