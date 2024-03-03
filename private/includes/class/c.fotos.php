<?php if ( ! defined('SYNTAXISLITEV3')) exit('No se permite el acceso directo al script');

/**
 * @name    c.fotos.php
 * @author  Miguel92
 * @copyright 2024
*/

class tsFotos {

	private $core;

	private $user;

	private $monitor;

	private $actividad;

	private $upload;

	private $uinfo;

	public function __construct() {
		$this->core = new tsCore;
		$this->user = new tsUser;
		$this->monitor = new tsMonitor;
		$this->actividad = new tsActividad;
		//
		include ROUTECLASS . 'c.upload.php';
		$this->upload = new tsUpload;
		//
		$this->uinfo['login'] = $this->user->is_member;
		$this->uinfo['baneado'] = (int)$this->user->info['user_baneado'] === 0;
		$this->uinfo['activo'] = (int)$this->user->info['user_activo'] === 1;
		$this->uinfo['admin'] = (int)$this->user->is_admod;
		$this->uinfo['permisos'] = (int)$this->user->permisos;
	}

	/**
	 * @access private
	 * @name controlData()
	 * @uses Verificar datos antes de ingresarlos
	*/
	private function controlData() {
		$data = [
         'f_title' => $tsCore->setSecure($tsCore->parseBadWords($_POST['f_title']), true),
         'foto' => [
         	'f_url' => $tsCore->setSecure($tsCore->parseBadWords($_POST['f_url'])), 
         	'file' => $_FILES['file']
         ],
         'f_description' => $tsCore->setSecure($tsCore->parseBadWords(substr($_POST['f_description'], 0, 500)), true),
         'f_closed' => empty($_POST['f_closed']) ? 0 : 1,
			'f_visitas' => empty($_POST['f_visitas']) ? 0 : 1,
			'f_ip' => $_SERVER['REMOTE_ADDR'],
			'f_date' => time()
       ];
       //
       return $data;
	}

	/**
	 * @access public
	 * @name newFoto()
	 * @uses Función para subir una nueva foto
	*/
	public function newFoto() {

		if($this->uinfo['login'] && $this->uinfo['baneado'] && $this->uinfo['activo'] && ($this->uinfo['admin'] || $this->uinfo['permisos']['gopf'])) {
			// Controlamos la información
			$fotoData = self::controlData();
		}

	}

}