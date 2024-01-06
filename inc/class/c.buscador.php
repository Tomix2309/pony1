<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Modelo para buscar usuarios, posts, fotos, etc
 *
 * @name    c.buscador.php
 * @author  Miguel92
 */
class tsBuscador {

	# BUSCADOR ORIGINAL
   public function getQuery() {
      global $tsCore, $tsUser;
      //
      $q = $tsCore->setSecure($_GET['q']);
      $c = intval($_GET['cat']);
      $a = $tsCore->setSecure($_GET['autor']);
      $e = $tsCore->setSecure($_GET['e']);
      if($e != 'fotos') {
         // ESTABLECER FILTROS
         if ($c > 0) $where_cat = 'AND p.post_category = \'' . (int) $c . '\'';
         $search_on = ($e == 'tags') ? 'p.post_tags' : 'p.post_title';
         // BUSQUEDA
         $w_search = "AND " . $search_on . " LIKE '%$q%'";
         // SELECCIONAR USUARIO
         if (!empty($a)) {
            // OBTENEMOS ID
            $aid = $tsUser->getUserID($a);
            // BUSCAR LOS POST DEL USUARIO SIN CRITERIO DE BUSQUEDA
            if (empty($q) && $aid > 0) $w_search = 'AND p.post_user = \'' . (int) $aid . '\'';
            elseif ($aid >= 1) $w_autor = 'AND p.post_user = \'' . (int) $aid . '\'';
         }
         // PAGINAS
         $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT COUNT(p.post_id) AS total FROM p_posts AS p WHERE p.post_status = \'0\' ' . $where_cat . ' ' . $w_autor . ' ' . $w_search . ' ORDER BY p.post_date');
         $total = db_exec('fetch_assoc', $query);
         $total = $total['total'];

         $data['pages'] = $tsCore->getPagination($total, 12);
         //
         $query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT p.post_id, p.post_user, p.post_category, p.post_title, p.post_portada, p.post_body, p.post_date, p.post_comments, p.post_favoritos, p.post_puntos, u.user_name, c.c_seo, c.c_nombre FROM p_posts AS p LEFT JOIN u_miembros AS u ON u.user_id = p.post_user LEFT JOIN p_categorias AS c ON c.cid = p.post_category WHERE p.post_status = \'0\' ' . $where_cat . ' ' . $w_autor . ' ' . $w_search . ' ORDER BY p.post_date DESC LIMIT ' . $data['pages']['limit']);
         $data['data'] = result_array($query);
         foreach ($data['data'] as $id => $row) {
            $data['data'][$id]['post_cover'] = $tsCore->extraer_img($data['data'][$id]['post_body']);
         }
      } else {
         // BUSQUEDA
         $w_search = "AND f.f_title LIKE '%$q%'";
         // SELECCIONAR USUARIO
         if (!empty($a)) {
            // OBTENEMOS ID
            $aid = $tsUser->getUserID($a);
            $aid = (int) $aid;
            // BUSCAR LOS POST DEL USUARIO SIN CRITERIO DE BUSQUEDA
            if (empty($q) && $aid > 0) $w_search = 'AND f.f_user = \'' . $aid . '\'';
            elseif ($aid >= 1) $w_autor = 'AND f.f_user = \'' . $aid . '\'';
         }
         // PAGINAS
         $query = db_exec(array(__FILE__, __LINE__), 'query', "SELECT COUNT(f.foto_id) AS total FROM f_fotos AS f WHERE f.f_status = 0 {$w_autor} {$w_search} ORDER BY f.f_date");
         $total = db_exec('fetch_assoc', $query);
         $total = $total['total'];

         $data['pages'] = $tsCore->getPagination($total, 12);
         //
         $query = db_exec(array(__FILE__, __LINE__), 'query', "SELECT f.foto_id, f.f_user, f.f_title, f.f_url, f.f_description, f.f_date, f.f_votos_pos, f.f_votos_neg, u.user_name FROM f_fotos AS f LEFT JOIN u_miembros AS u ON u.user_id = f.f_user WHERE f.f_status = 0 {$w_autor} {$w_search} ORDER BY f.f_date DESC LIMIT " . $data['pages']['limit']);
         $data['data'] = result_array($query);
      }
      // ACTUALES
      $total = explode(',', $data['pages']['limit']);
      $data['total'] = ($total[0]) + count($data['data']);
      //
      return $data;
   }

   # BUSCARDOR AJAX
   function SearchAjax($word) {
      global $tsCore, $tsUser;
      
      $search_on = 'p.post_title';
      $word = $tsCore->setSecure($word);

      $query = db_exec(array(__FILE__, __LINE__), 'query', "SELECT p.post_id, p.post_user, p.post_category, p.post_title, p.post_portada, p.post_body, p.post_date, p.post_comments, p.post_favoritos, p.post_puntos, u.user_name, c.c_seo, c.c_nombre FROM p_posts AS p LEFT JOIN u_miembros AS u ON u.user_id = p.post_user LEFT JOIN p_categorias AS c ON c.cid = p.post_category WHERE p.post_title LIKE '%$word%' ORDER BY p.post_date DESC LIMIT 7");
      $data['data'] = result_array($query);
      foreach ($data['data'] as $id => $row) {
         $data['data'][$id]['post_cover'] = $tsCore->extraer_img($data['data'][$id]['post_body']);
      }
      $data['total'] = db_exec('num_rows', $query);
      return $data;
   }

   # BUSCADOR USUARIOS PARA ENVIAR MENSAJES
   function BuscarUsuarios() {
   	global $tsCore, $tsUser;
      # Creamos un arreglo para el metodo post!
      $U = array(
         "id" => intval($_POST['id']),
         "usuarios" => $tsCore->setSecure($_POST['users']),
         "todos" => $tsCore->setSecure($_POST['s']),
      );
      # Evitaremos inyecciones de SQL
      $all = $tsCore->setSecure($U['todos']);
   	$usuarios = $tsCore->setSecure($U['usuarios']);
      # Evitamos que salga nuestro usuario
      $MiId = "u.user_id != " . (int)$U['id'];
      # Creamos la sentencia
	   $sentencia = ($all == 'todos') ? "u.user_id, u.user_name, u.user_activo, u.user_baneado FROM u_miembros AS u WHERE {$MiId}" : "DISTINCT u.user_id, u.user_name, u.user_activo, u.user_baneado FROM u_miembros AS u WHERE {$MiId} AND u.user_name LIKE '%$usuarios%'";
		# Ejecutamos la sentencia
		$query = db_exec(array(__FILE__, __LINE__), 'query', "SELECT {$sentencia} ORDER BY u.user_id ASC");
      # Mostramos
   	$data = ($usuarios == '') ? '' : result_array($query);
      # Devolvemos el campo indicado
   	return $data;
   }
}