<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * Funciones globales
 *
 * @name    c.core.php
 * @author  PHPost Team
 */
class tsCore {
    
	public $settings;		// CONFIGURACIONES DEL SITIO
	
	private $keygen = 'SL2-M1g43l92-';

  # Comprobamos el certificado o protocolo HTTPs | SSL
	function getSSL() {
		if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
 			$isSecure = false;
		} elseif (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
      	$isSecure = true;
    	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
      	$isSecure = true;
    	}
    	$isSecure = ($isSecure == true) ? 'https://' : 'http://';
    	return $isSecure;
	}

	function __construct() {
		// CARGANDO CONFIGURACIONES
		$this->settings 					= $this->getSettings();
		$this->settings['ads'] 			= $this->getAds();
		$this->settings['domain'] 		= str_replace($this->getSSL(),'',$this->settings['url']);
		$this->settings['categorias'] = $this->getCategorias();
      $this->settings['default'] 	= $this->settings['url'].'/themes/default';
		$this->settings['tema'] 		= $this->getTema();
		$this->settings['images'] 		= $this->settings['tema']['t_url'].'/images';
      $this->settings['css'] 			= $this->settings['tema']['t_url'].'/css';
		$this->settings['js'] 			= $this->settings['tema']['t_url'].'/js';
		// FILES
		$this->settings['files'] 		= $this->settings['url'].'/files';
		$this->settings['avatar'] 		= $this->settings['files'].'/avatar';
		$this->settings['avatares'] 	= $this->settings['files'].'/avatares';
		$this->settings['uploads'] 	= $this->settings['files'].'/uploads';
      $this->settings['news'] 		= $this->getNews();
      $this->settings['oauth'] 		= $this->OAuth();
		# Mensaje del instalador y pendientes de moderación #
		$this->settings['install'] 		= $this->existinstall();
		$this->settings['novemods']		= $this->getNovemods();
		$this->settings['cambiodenicks'] = $this->getNicks();
	}
	public function getEndPoints(string $social = '', string $type = '') {
		$getEndPoints = [
			'google' => [
				'authorize_url' => 'https://accounts.google.com/o/oauth2/auth',
				'token' => "https://accounts.google.com/o/oauth2/token",
				'user' => "https://www.googleapis.com/oauth2/v2/userinfo",
				'scope' => "https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile"
			],
			'github' => [
				'authorize_url' => 'https://github.com/login/oauth/authorize',
				'token' => "https://github.com/login/oauth/access_token",
				'user' => "https://api.github.com/user",
				'scope' => "user"
			]
		];
		return $getEndPoints[$social][$type];
	}

	public function OAuth() {
		$OAuths = result_array(db_exec([__FILE__, __LINE__], 'query', 'SELECT social_id, social_name, social_client_id, social_client_secret, social_redirect_uri FROM w_social'));
		foreach($OAuths as $k => $auth) {
			$parametros = [
				'client_id' => $auth['social_client_id'],
				'scope' => $this->getEndPoints($auth['social_name'], 'scope'),
				'state' => strtolower($this->settings['titulo']).date('y'),
				'response_type' => 'code',
				'redirect_uri' => $auth['social_redirect_uri']
			];
			if($auth['social_name'] === 'github') unset($parametros['response_type']);
			$parametros = http_build_query($parametros);
			$authorize = $this->getEndPoints($auth['social_name'], 'authorize_url');
			$ruta[$auth['social_name']] = "$authorize?$parametros";
		}
		return $ruta;
	}
	/*
		getSettings() :: CARGA DESDE LA DB LAS CONFIGURACIONES DEL SITIO
	*/
	function getSettings() {
		return db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT * FROM w_configuracion'));
	}
	function getAds(){
		return db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT * FROM w_ads'));
	}
	
	function getNovemods() {
      $datos = db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT (SELECT count(post_id) FROM p_posts WHERE post_status = \'3\') as revposts, (SELECT count(cid) FROM p_comentarios WHERE c_status = \'1\' ) as revcomentarios, (SELECT count(DISTINCT obj_id) FROM w_denuncias WHERE d_type = \'1\') as repposts, (SELECT count(DISTINCT obj_id) FROM w_denuncias WHERE d_type = \'2\') as repmps, (SELECT count(DISTINCT obj_id) FROM w_denuncias WHERE d_type = \'3\') as repusers, (SELECT count(DISTINCT obj_id) FROM w_denuncias  WHERE d_type = \'4\') as repfotos, (SELECT count(susp_id) FROM u_suspension) as suspusers, (SELECT count(post_id) FROM p_posts WHERE post_status = \'2\') as pospelera, (SELECT count(foto_id) FROM f_fotos WHERE f_status = \'2\') as fospelera'));
		$datos['total'] = $datos['repposts'] + $datos['repfotos'] + $datos['repmps'] + $datos['repusers'] + $datos['revposts'] + $datos['revcomentarios'];
		return $datos;  
	}
	/* CHANGE NICKS */
	function getNicks() {
      $datos = db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', 'SELECT (SELECT count(id) FROM u_nicks WHERE estado = \'0\') as nicks'));
		$datos['total'] = $datos['nicks'];
		return $datos;  
	}
	/*
		getCategorias()
	*/
	function getCategorias() {
		return result_array(db_exec(array(__FILE__, __LINE__), 'query', 'SELECT * FROM p_categorias ORDER BY c_orden'));
	}
	/*
		getTema()
	*/
	function getTema() {
		//
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT * FROM w_temas WHERE tid = '.$this->settings['tema_id'].' LIMIT 1');
		//
		$data = db_exec('fetch_assoc', $query);
      $data['t_url'] = $this->settings['url'] . '/themes/' . $data['t_path'];
		//
		return $data;
	}
	/*
        getNews()
    */
   function getNews() {
      //
		$query = db_exec(array(__FILE__, __LINE__), 'query', 'SELECT not_body FROM w_noticias WHERE not_active = \'1\' ORDER by RAND()');
		while($row = db_exec('fetch_assoc', $query)){
		  	$row['not_body'] = $this->parseBBCode($row['not_body'],'news');
         $data[] = $row;
		}
      //
      return $data;
   }
	//COMPROBACIONES DE LA EXISTENCIA DEL INSTALADOR O ACTUALIZADOR
	function existinstall() {
		$install_dir = TS_ROOT . '/install/';
		$upgrade_dir = TS_ROOT . '/upgrade/';
		if(is_dir($install_dir)) return '<div id="msg_install">Por favor, elimine la carpeta <b>install</b></div>';		
		if(is_dir($upgrade_dir)) return '<div id="msg_install">Por favor, elimine la carpeta <b>upgrade</b></div>';
	}
   # Función para censurar
	function parseBadWords($c, $s = FALSE) {
      $w = ($s == true) ? '' : " WHERE type = 0";
		$q = result_array(db_exec([__FILE__, __LINE__], 'query', "SELECT word, swop, method, type FROM w_badwords {$w}"));
      foreach($q AS $badword) {
      	$from = (empty($badword['method']) ? $badword['word'] : $badword['word'].' ');
      	$to = ($badword['type'] == 1) ? '<img title="'.$badword['word'].'" alt="'.$badword['word'].'" src="'.$badword['swop'].'"/>' : ($badword['type'] == 2 ? '<smile title="'.$badword['word'].'" alt="'.$badword['word'].'">'.$this->parseSmiles($badword['swop']).'</smile>' : $badword['swop'].' ');
      	$c = str_replace($from, $to, $c);
      }
      return $c;
	}        
	
	/*
		setLevel($tsLevel) :: ESTABLECE EL NIVEL DE LA PAGINA | MIEMBROS o VISITANTES
	*/
	function setLevel($tsLevel, $msg = false){
		global $tsUser;
		// CUALQUIERA
		if($tsLevel == 0) return true;
		// SOLO VISITANTES
		elseif($tsLevel == 1) {
			if($tsUser->is_member == 0) return true;
			else {
				if($msg) {
					$mensaje = '<i class="icon_svg icon_svg_1 d-block"></i>';
					$mensaje .= '<p class="text-uppercase font-weight-bolder h4 pt-2 pb-4 d-block text-center">Esta pagina solo es vista por los visitantes.</p>';
				} else $this->redirectTo('/');
			}
		} elseif($tsLevel == 2){ # SOLO MIEMBROS
			if($tsUser->is_member == 1) return true;
			else {
				if($msg) {
					$mensaje = '<i class="icon_svg icon_svg_2 d-block"></i>';
					$mensaje .= '<p class="text-uppercase font-weight-bolder h4 pt-2 pb-4 d-block text-center">Para poder ver esta pagina debes iniciar sesi&oacute;n.</p>';
				} else $this->redirectTo('/login/?r='.$this->currentUrl());
			}
		} elseif($tsLevel == 3) { # SOLO MODERADORES
			if($tsUser->is_admod || $tsUser->permisos['moacp']) return true;
			else {
				if($msg) {
					$mensaje = '<i class="icon_svg icon_svg_3 d-block"></i>';
					$mensaje .= '<p class="text-uppercase font-weight-bolder h4 pt-2 pb-4 d-block text-center">Estas en un area restringida solo para moderadores.</p>';
				} else $this->redirectTo('/login/?r='.$this->currentUrl());
			}
		} elseif($tsLevel == 4) { #SOLO ADMIN
			if($tsUser->is_admod == 1) return true;
			else {
				if($msg) {
					$mensaje = '<i class="icon_svg icon_svg_4 d-block"></i>';
					$mensaje .= '<p class="text-uppercase font-weight-bolder h4 pt-2 pb-4 d-block text-center">Estas intentando algo no permitido.</p>';
				} else $this->redirectTo('/login/?r='.$this->currentUrl());
			}
		}
		//
		return array('titulo' => 'Error', 'mensaje' => $mensaje);
	}
	# Redireccionamos
	function redirectTo($tsDir){
		$tsDir = urldecode($tsDir);
		header("Location: $tsDir");
		exit();
	}
   # Obtenemos el dominio
   function getDomain(){
      $domain = explode('/', str_replace($this->getSSL(), '', $this->settings['url']));
      $domain = (is_array($domain)) ? explode('.',$domain[0]) : explode('.',$domain);
      //
      $t = safe_count($domain);
      $domain = $domain[$t - 2].'.'.$domain[$t - 1];
      //
      return $domain;
   }
	# Obtenemos url codificada
	function currentUrl(){
		$current_url_domain = $_SERVER['HTTP_HOST'];
		$current_url_path = $_SERVER['REQUEST_URI'];
		$current_url_querystring = $_SERVER['QUERY_STRING'];
		$current_url = $this->getSSL() . $current_url_domain . $current_url_path;
		$current_url = urlencode($current_url);
		return $current_url;
	}
	# Función json
	function setJSON($data = NULL, $type = 'encode', $t = false){
      return ($type == 'encode') ? json_encode($data, $t) : json_decode($data);            
	}
	/*
		setPagesLimit($tsPages, $start = false)
	*/
	function setPageLimit($tsLimit, $start = false, $tsMax = 0){
		if($start == false)
		$tsStart = empty($_GET['page']) ? 0 : (int) (($_GET['page'] - 1) * $tsLimit);
		else {
    		$tsStart = (int) $_GET['s'];
            $continue = $this->setMaximos($tsLimit, $tsMax);
            if($continue == true) $tsStart = 0;
        }
		//
		return $tsStart.','.$tsLimit;
	}
    /*
        setMaximos()
        :: MAXIMOS EN LAS PAGINAS
    */
    function setMaximos($tsLimit, $tsMax){
        // MAXIMOS || PARA NO EXEDER EL NUMERO DE PAGINAS
        $ban1 = ($_GET['page'] * $tsLimit);
        if($tsMax < $ban1){
            $ban2 = $ban1 - $tsLimit;
            if($tsMax < $ban2) return true;
        } 
        //
        return false;
    }
	/*
		getPages($tsTotal, $tsLimit)
		: PAGINACION
	*/
	function getPages($tsTotal, $tsLimit){
		//
		$tsPages = ceil($tsTotal / $tsLimit);
		// PAGINA
		$tsPage = empty($_GET['page']) ? 1 : $_GET['page'];
		// ARRAY
		$pages['current'] = $tsPage;
		$pages['pages'] = $tsPages;
		$pages['section'] = $tsPages + 1;
		$pages['prev'] = $tsPage - 1;
		$pages['next'] = $tsPage + 1;
        $pages['max'] = $this->setMaximos($tsLimit, $tsTotal);
		// RETORNAMOS HTML
		return $pages;
	}
    /*
        getPagination($total, $per_page)
    */
    function getPagination($total, $per_page = 10){
        // PAGINA ACTUAL
        $page = empty($_GET['page']) ? 1 : (int) $_GET['page'];
        // NUMERO DE PAGINAS
        $num_pages = ceil($total / $per_page);
        // ANTERIOR
        $prev = $page - 1;
        $pages['prev'] = ($page > 0) ? $prev : 0;
        // SIGUIENTE 
        $next = $page + 1;
        $pages['next'] = ($next <= $num_pages) ? $next : 0;
        // LIMITE DB
        $pages['limit'] = (($page - 1) * $per_page).','.$per_page; 
        // TOTAL
        $pages['total'] = $total;
        //
        return $pages;
    }
    /**/
	// Constructs a page list.
	// $pageindex = constructPageIndex($scripturl . '?board=' . $board, $_REQUEST['start'], $num_messages, $maxindex, true);
	function pageIndex($base_url, &$start, $max_value, $num_per_page, $flexible_start = false){
        // QUITAR EL S de la base_url
        $base_url = explode('&s=',$base_url);
        $base_url = $base_url[0];
		// Save whether $start was less than 0 or not.
		$start_invalid = $start < 0;
	
		// Make sure $start is a proper variable - not less than 0.
		if ($start_invalid)
			$start = 0;
		// Not greater than the upper bound.
		elseif ($start >= $max_value)
			$start = max(0, (int) $max_value - (((int) $max_value % (int) $num_per_page) == 0 ? $num_per_page : ((int) $max_value % (int) $num_per_page)));
		// And it has to be a multiple of $num_per_page!
		else
			$start = max(0, (int) $start - ((int) $start % (int) $num_per_page));
	
		$base_link = '<a class="navPages" href="' . ($flexible_start ? $base_url : strtr($base_url, array('%' => '%%')) . '&s=%d') . '">%s</a> ';
	
			// If they didn't enter an odd value, pretend they did.
			$PageContiguous = (int) (5 - (5 % 2)) / 2;
	
			// Show the first page. (>1< ... 6 7 [8] 9 10 ... 15)
			if ($start > $num_per_page * $PageContiguous)
				$pageindex = sprintf($base_link, 0, '1');
			else
				$pageindex = '';
	
			// Show the ... after the first page.  (1 >...< 6 7 [8] 9 10 ... 15)
			if ($start > $num_per_page * ($PageContiguous + 1))
				$pageindex .= '<b> ... </b>';
	
			// Show the pages before the current one. (1 ... >6 7< [8] 9 10 ... 15)
			for ($nCont = $PageContiguous; $nCont >= 1; $nCont--)
				if ($start >= $num_per_page * $nCont)
				{
					$tmpStart = $start - $num_per_page * $nCont;
					$pageindex.= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
				}
	
			// Show the current page. (1 ... 6 7 >[8]< 9 10 ... 15)
			if (!$start_invalid)
				$pageindex .= '[<b>' . ($start / $num_per_page + 1) . '</b>] ';
			else
				$pageindex .= sprintf($base_link, $start, $start / $num_per_page + 1);
	
			// Show the pages after the current one... (1 ... 6 7 [8] >9 10< ... 15)
			$tmpMaxPages = (int) (($max_value - 1) / $num_per_page) * $num_per_page;
			for ($nCont = 1; $nCont <= $PageContiguous; $nCont++)
				if ($start + $num_per_page * $nCont <= $tmpMaxPages)
				{
					$tmpStart = $start + $num_per_page * $nCont;
					$pageindex .= sprintf($base_link, $tmpStart, $tmpStart / $num_per_page + 1);
				}
	
			// Show the '...' part near the end. (1 ... 6 7 [8] 9 10 >...< 15)
			if ($start + $num_per_page * ($PageContiguous + 1) < $tmpMaxPages)
				$pageindex .= '<b> ... </b>';
	
			// Show the last number in the list. (1 ... 6 7 [8] 9 10 ... >15<)
			if ($start + $num_per_page * $PageContiguous < $tmpMaxPages)
				$pageindex .= sprintf($base_link, $tmpMaxPages, $tmpMaxPages / $num_per_page + 1);
	
		return $pageindex;
	}
	/*
		setSecure()
	*/
	public function setSecure($var, $xss = FALSE) {
      $var = db_exec('real_escape_string', function_exists('magic_quotes_gpc') ? stripslashes($var) : $var);
      if($xss):
      	$var = htmlspecialchars($var, ENT_NOQUOTES, 'UTF-8');
      endif;
    	return $var;
   }
	# Anti-flood
   public function antiFlood($print = true, $type = 'post', $msg = '') {
      global $tsUser;
      //
      $now = time();
      $msg = empty($msg) ? 'No puedes realizar tantas acciones en tan poco tiempo.' : $msg;
      //
      $limit = $tsUser->permisos['goaf'];
      $resta = $now - $_SESSION['flood'][$type];
      if($resta < $limit) {
      	$seconds = ($limit - $resta);
         $msg = "0: {$msg} Int&eacute;ntalo en <b>{$seconds}</b> segundos.";
         // TERMINAR O RETORNAR VALOR
         if($print) die($msg);
         else return $msg;
      } else {
         // ANTIFLOOD
         $_SESSION['flood'][$type] = (empty($_SESSION['flood'][$type])) ? time() : $now;
         // TODO BIEN
         return true;
      }
   }
	# MAXIMA CONVERSION => URL AMIGABLES | MAX no se usa
	function setSEO($string, $max = NULL) {
		$string = htmlentities($string, ENT_QUOTES, 'UTF-8');
		$string = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$string = preg_replace('~[^0-9a-z]+~i', '-', $string);
		$string = strtolower(trim($string, '-'));
		return $string;
	}
	/*
		parseBBCode($bbcode)
	*/
	function parseBBCode($bbcode, $type = 'normal', $act = 0, $title = null, $menciones = false) {
      // Class BBCode
      include_once(TS_EXTRA . 'bbcode.inc.php');
      $parser = new BBCode();
      
      // Seleccionar texto
      $parser->setText($bbcode);

      // Seleccionar tipo
      switch ($type) {
         // NORMAL
         case 'normal':
            // BBCodes permitidos
            $parser->setRestriction(array('url', 'code', 'quote', 'font', 'size', 'color', 'img', 'b', 'i', 'u', 's', 'align', 'spoiler', 'video', 'hr', 'sub', 'sup', 'ul', 'li', 'ol', 'thumbnails', 'trailer', 'capturas', 'descargas', 'servidores', 'info-movie', 'item', 'links'), $act, $title);
            // SMILES
            $parser->parseSmiles();
            // MENCIONES
            if($menciones) $parser->parseMentions();
         break;
         // FIRMA
         case 'firma':
            // BBCodes permitidos
            $parser->setRestriction(array('url', 'font', 'size', 'color', 'img', 'b', 'i', 'u', 's', 'align', 'spoiler'));
         break;
         // NOTICIAS
         case 'news':
            // BBCodes permitidos
            $parser->setRestriction(array('url', 'b', 'i', 'u', 's'));
            // SMILES
            $parser->parseSmiles();
         break;
         // FILES
         case 'files':
            // RESTRICTIONS
            $parser->setRestriction(array('url', 'quote', 'size', 'color', 'b', 'i', 'u', 'align'));
            // SMILES
            $parser->parseSmiles();
            // MENCIONES
            $parser->parseMentions();
         break; 
         // SOLO SMILES (Esta opción se mantiene por compatibilidad con versiones anteriores, pero en su lugar se recomienda utilizar la opción "normal")
         case 'smiles':
            $parser->setRestriction(array('url', 'code', 'quote', 'font', 'size', 'color', 'img', 'b', 'i', 'u', 'align', 'spoiler', 'hr', 'li'));
             // SMILES
            $parser->parseSmiles();
            // MENCIONES
            $parser->parseMentions();
         break;
      }
      // Retornar resultado HTML
      return $parser->getAsHtml();
   }
   /**
    * @name setMenciones
    * @access public
    * @param string
    * @return string
    * @info PONE LOS LINKS A LOS MENCIONADOS
    * @note Esta función se ha reemplazado por $parser->parseMentions(). Se reomienda exclusivamente para compatibilidad en versiones anteriores.
   */
   public function setMenciones($html){
      # GLOBALES
      global $tsUser;
      # HACK
      $html = $html.' ';
      # BUSCAMOS A USUARIOS
      preg_match_all('/\B@([a-zA-Z0-9_-]{4,16}+)\b/',$html, $users);
      $menciones = $users[1];
      # VEMOS CUALES EXISTEN
      foreach($menciones as $key => $user){
         $uid = $tsUser->getUserID($user);
         if(!empty($uid)) {
            $find = "@{$user} ";
            $replace = "@<a href=\"{$this->settings['url']}/perfil/{$user}\">{$user}</a> ";
            $html = str_replace($find, $replace, $html);
         }
      }
      # RETORNAMOS
      return $html;
   }
   # parseSmiles($st)
   public function parseSmiles($bbcode) { return $this->parseBBCode($bbcode, 'smiles'); }
	# parseBBCodeFirma($bbcode)
	function parseBBCodeFirma($bbcode) { return $this->parseBBCode($bbcode, 'firma'); }
	/*
		setHace()
	*/
	public function setHace(int $fecha = 0, $show = false){
      # Creamos
      $tiempo = time() - $fecha;
      if($fecha <= 0) return "Nunca";
      // Declaración de unidades de tiempo, aunque es un aproximado
      // Ya que existe años bisiestos 366 días
      $unidades = [
        31536000 => ["a&ntilde;o", "a&ntilde;os"],
        2678400 => ["mes", "meses"],
        604800 => ["semana", "semanas"],
        86400 => ["d&iacute;a", "d&iacute;as"],
        3600 => ["hora", "horas"],
        60 => ["minuto", "minutos"],
      ];
      foreach($unidades as $segundos => $nombre){
         $round = round($tiempo / $segundos);
         $s = ($segundos === 2678400) ? 'es' : 's';
         if($tiempo <= 60) $hace = "instantes";
         else {
            if($round > 0) {
               $hace = "{$round} {$nombre[($round > 1 ? 1 : 0)]}";
               break;
            }
         }
      }
      // Si se ha establecido la opción $show, se agrega 'Hace' al resultado
      return ($show ? "Hace " : "") . $hace;
   }
	/*
		getUrlContent($tsUrl) :: Mejorado
	*/
	public function getUrlContent(string $tsUrl): ?string {
    	// USAMOS CURL O FILE
    	if (function_exists('curl_init')) {
        	// Obtener el user agent del cliente
    		//'Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9) Gecko/2008052906 Firefox/3.0'
        	$useragent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        	// Abrir conexión  
        	$ch = curl_init();
        	curl_setopt_array($ch, [
            CURLOPT_URL => $tsUrl,
            CURLOPT_USERAGENT => $useragent,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_RETURNTRANSFER => true,
        	]);
        	$result = curl_exec($ch);
        	curl_close($ch);
    	} else $result = @file_get_contents($tsUrl);
    	return $result ?: null;
	}
    /*
        getIP
    */
    function getIP(){
	   if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) $ip = getenv('HTTP_CLIENT_IP');	
	   elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) $ip = getenv('HTTP_X_FORWARDED_FOR');
	   elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) $ip = getenv('REMOTE_ADDR');
	   elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) $ip = $_SERVER['REMOTE_ADDR'];
	   else $ip = 'unknown';
	   return $this->setSecure($ip);
   }
	
	/**
	 * Función para ayudar armar la sentencia en UPDATE
	 * @param array ['name' => 'john', 'password' => '123abc']
	 * @param string 'user_'
	 * @return string|null EJ: user_name = 'john', user_password = '123abc'...
	*/
	public function getIUP(array $array = [], string $prefix = ''): string {
	   $sets = [];
	   foreach ($array as $field => $value) $sets[] = "$prefix$field = " . (is_numeric($value) ? (int)$value : "'{$this->setSecure($value)}'");
	   return implode(', ', $sets);
	}
	/**
	 * Función para obtener el avatar
	*/
	public function getAvatar(int $uid = 0):string {
		$user = db_exec('fetch_assoc', db_exec([__FILE__, __LINE__], 'query', "SELECT m.user_id, m.user_avatar, p.p_avatar FROM u_miembros AS m LEFT JOIN u_perfil AS p ON p.user_id = m.user_id WHERE m.user_id = $uid"));
		$ensamble = ((int)$user['p_avatar'] === 1) ? "{$user['user_id']}.{$user['user_avatar']}" : "avatar";
		return "{$this->settings['avatar']}/$ensamble.webp?" . time();
	}
	/**
	 * Función para generar la contraseña
	 * y/o verificar la contraseña del usuario
	 * @param string 
	 * @param string 
	 * @return string
	*/
	public function passwordSL2(string $username = '', string $password = '', string $verify = '') {
		$options = ['cost' => 12];
		$createPass = $this->keygen . $username . $password;
		$response = password_hash($createPass, PASSWORD_BCRYPT, $options);
		if(!empty($verify)) $response = (int)password_verify($createPass, $verify);
		return $response;
	}
	/*
     * Sacar imagen del post
     * si hay mas de una imagen, tomamos la 2 (casi siempre la 1 es de "bienvenido")
   */
   public function extraer_img($texto) {
      // del tipo [img=imagen] o [img=imagen]
      preg_match_all('/(\[img(\=|\]))((http|https)?(\:\/\/)?([^\<\>[:space:]]+)\.(jpg|jpeg|png|gif))(\]|\[\/img\])/i', $texto, $imgs);
      $total = safe_count($imgs[3]);
      // Sacamos la mejor imagen posible ._.
      $img = (count($imgs[3]) > 1) ? $imgs[3][1] : $imgs[3][0];    
      if(empty($img)) $img = $this->settings['files'] . '/SyntaxisLite-ico.png';
      //
      return $img;
   }	
   public function nobbcode($nobbcode = ''){
		$nobbcode = preg_replace('/\[([^\]]*)\]/', '', $nobbcode); 
		$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
		$nobbcode = preg_replace($regex, ' ', $nobbcode);
		return $nobbcode;
	}
	public function truncate($string = '', $can = NULL){
		$stc = ($can == '') ? '150' : $can;
		$str = wordwrap($string, $stc);
		$str = str_replace('&nbsp;', ' ', $str);
		$str = explode("\n", $str);
		$str = $str[0] . '...';
		return $str;
	}
	public function timeseo($time = '') {
		$time = date('Y-m-d\TH:i:s\Z', $time);
		return $time;
	}
	public function convertirms($segundos) {
   	$minutos = floor($segundos / 60);
   	$segundos = $segundos % 60;
   	return sprintf("%02d:%02d", $minutos, $segundos);
	}

}