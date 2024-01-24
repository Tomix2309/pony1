<?php if (!defined('TS_HEADER')) {
   exit('No se permite el acceso directo al script');
}

/**
 * Modelo para subir im�genes
 *
 * @name    c.upload.php
 * @author  PHPost Team
 */
class tsUpload {

   public $type        = 1; // TIPO DE SUBIDA

   public $max_size    = 2097152; // 2MB

   public $allow_types = ['png', 'gif', 'jpg', 'webp', 'jpeg']; // ARCHIVOS PERMITIDOS

   public $found       = 0; // VARIABLE BANDERA

   public $file_url    = ''; // URL

   public $file_size   = []; // TAMA�O DEL ARCHIVO REMOTO

   public $image_size  = ['w' => 570, 'h' => 450];

   public $image_scale = false;

   public $servers     = [];

   public $server      = 'imgur'; // DEFAULT IMGUR

   private $prefix     = 'syntaxislite2_';

   // CONSTRUCTOR
   public function __construct() {
      $this->servers = ['imgur' => 'https://api.imgur.com/3/image.json'];
   }
   /*
   newUpload($type)
   :: $type => URL o ARCHIVO
    */
   public function newUpload(int $type = 1) {
      $this->type = $type;
      // ARCHIVOS
      if ($this->type == 1) {
         foreach ($_FILES as $file) $fReturn[] = $this->uploadFile($file);
      // DESDE URL
      } elseif ($this->type == 2) {
         $fReturn[] = $this->uploadUrl();
         // CROP
      } elseif ($this->type == 3) {
         if (empty($this->file_url)) {
            foreach ($_FILES as $file) $fReturn = $this->uploadFile($file);
            if (empty($fReturn['msg'])) return array('error' => $fReturn[1]);
         } else {
            $file = [
               'name'     => substr($this->file_url, -4),
               'type'     => 'image/url',
               'tmp_name' => $this->file_url,
               'error'    => 0,
               'size'     => 0,
            ];
            //
            $fReturn = $this->uploadFile($file, 'url');
            if (empty($fReturn['msg'])) return ['error' => $fReturn[1]];
         }
      }
      return ($this->found == 0) ? ['error' => 'No se ha seleccionado archivo alguno.'] : $fReturn;
   }
   /*
   uploadFiles()
    */
   public function uploadFile($file, $type = 'file') {
      // VALIDAR
      $error = $this->validFile($file, $type);
      if (!empty($error)) return [0, $error];
      else {
         $type    = explode('/', $file['type']);
         $ext     = ($type[1] == 'jpeg' || $type[1] == 'url') ? 'jpg' : $type[1]; // EXTENCION
         $key     = rand(0, 1000);
         $newName = $this->prefix . $key . '.' . $ext;
         // IMAGEN
         if ($this->type == 1) return [1, $this->sendFile($file, $newName), $type[1]];
         // CROP
         else {
            return [
               'msg' => $this->createImage($file, $newName), 
               'error' => '', 
               'key' => $key, 
               'ext' => $ext
            ];
         }
      }
   }
   /*
   uploadUrl()
    */
   public function uploadUrl() {
      $error = $this->validFile(null, 'url');
      return (!empty($error)) ? [0, $error] : [1, urldecode($this->file_url)];
   }
   /*
   validFile()
    */
   public function validFile($file, $type = 'file') {
      // ARCHIVO
      if ($type == 'file') {
         // SE ENCONTRO EL ARCHIVO
         if (empty($file['name'])) return 'No Found';
         else $this->found = $this->found + 1;
         //
         $type = explode('/', $file['type']);
         if ($file['size'] > $this->max_size) {
            return "#{$this->found} pesa mas de 1 MB.";
         } elseif (!in_array($type[1], $this->allow_types)) {
            return "#{$this->found} no es una imagen.";
         }
      } elseif ($type == 'url') {
         $this->file_size = getimagesize($this->file_url);
         // TAMA�O MINIMO
         $min_w = $min_h = 160;
         // MAX PARA EVITAR CARGA LENTA
         $max_w = $max_h = 1024;
         $this->found = 1;
         //
         if (empty($this->file_size[0])) {
            return 'La url ingresada no existe o no es una imagen v&aacute;lida.';
         } elseif ($this->file_size[0] < $min_w || $this->file_size[1] < $min_h) {
            return 'Tu foto debe tener un tama&ntilde;o superior a 160x160 pixeles.';
         } elseif ($this->file_size[0] > $max_w || $this->file_size[1] > $max_h) {
            return 'Tu foto debe tener un tama&ntilde;o menor a 1024x1024 pixeles.';
         }

      }
      // TODO BIEN
      return false;
   }
   /*
   sendFile($file,$name)
    */
   public function sendFile($file, $name) {
      $url = $this->createImage($file, $name);
      // SUBIMOS...
      $new_img = $this->getImagenUrl($this->uploadImagen($this->setParams($url)));
      // BORRAR
      $this->deleteFile($name);
      // REGRESAMOS
      return $new_img;
   }
   /*
   copyFile($file, $name)
    */
   public function copyFile($file, $name) {
      global $tsCore;
      // COPIAMOS
      copy($file['tmp_name'], TS_UPLOADS . $name);
      // REGRESAMOS LA URL
      return $tsCore->settings['uploads'] . '/' . $name;
   }
   /*
   createImage()
    */
   public function createImage($file, $name) {
      global $tsCore;
      // TAMA�O
      $size = empty($this->file_size) ? getimagesize($file['tmp_name']) : $this->file_size;
      if (empty($size)) {
         die('0: Intentando subir un archivo que no es valido.');
      }
      $width  = $size[0];
      $height = $size[1];
      // ESCALAR SOLO SI LA IMAGEN EXEDE EL TAMA�O Y SE DEBE ESCALAR
      if ($this->image_scale == true && ($width > $this->image_size['w'] || $height > $this->image_size['h'])) {
         // OBTENEMOS ESCALA
         if ($width > $height) {
            $_height = ($height * $this->image_size['w']) / $width;
            $_width  = $this->image_size['w'];
         } else {
            $_width  = ($width * $this->image_size['h']) / $height;
            $_height = $this->image_size['h'];
         }
         // TIPO
         switch ($file['type']) {
            case 'image/url':
               $img = imagecreatefromstring($tsCore->getUrlContent($file['tmp_name']));
            break;
            case 'image/jpeg':
            case 'image/jpg':
               $img = imagecreatefromjpeg($file['tmp_name']);
            break;
            case 'image/gif':
               $img = imagecreatefromgif($file['tmp_name']);
            break;
            case 'image/png':
               $img = imagecreatefrompng($file['tmp_name']);
            break;
         }
         // ESCALAMOS NUEVA IMAGEN
         $newimg = imagecreatetruecolor($_width, $_height);
         imagecopyresampled($newimg, $img, 0, 0, 0, 0, $_width, $_height, $width, $height);
         // COPIAMOS
         $root = TS_UPLOADS . $name;
         imagejpeg($newimg, $root, 100);
         imagedestroy($newimg);
         imagedestroy($img);
         // RETORNAMOS
         return $tsCore->settings['uploads'] . '/' . $name;
      // MANTENEMOS LAS DIMENCIONES Y SOLO COPIAMOS LA IMAGEN
      } else return $this->copyFile($file, $name);
   }/**
    * @name cropAvatar()
    * @uses Creamos el avatar a partir de las coordenadas resibidas
    * @access public
    * @param int
    * @return array
    */
   public function cropAvatar(string $key = '') {
      global $tsCore;

      $source = TS_UPLOADS . $this->prefix . $_POST['key'] . '.' . $_POST['ext'];
      $size   = getimagesize($source);
      // COORDENADAS
      $x = $_POST['x'];
      $y = $_POST['y'];
      $w = $_POST['w'];
      $h = $_POST['h'];
      // TAMA�OS
      $_w = $_h = 160;
      // CREAMOS LA IMAGEN DEPENDIENDO EL TIPO
      switch ($size['mime']) {
         case 'image/jpeg':
         case 'image/jpg':
            $img = imagecreatefromjpeg($source);
         break;
         case 'image/gif':
            $img = imagecreatefromgif($source);
         break;
         case 'image/png':
            $img = imagecreatefrompng($source);
         break;
      }
      if (!$img) return array('error' => 'No pudimos crear tu avatar...');
      //
      $width  = imagesx($img);
      $height = imagesy($img);
      // AVATAR
      $avatar = imagecreatetruecolor($_w, $_h);
      imagecopyresampled($avatar, $img, 0, 0, $x, $y, $_w, $_h, $w, $h);
      // GUARDAMOS...
      # CONVERTIREMOS LOS AVATARES JPG A WEBP
      $imgWEBP = TS_AVATAR . $key . '.webp';

      if (file_exists($source)) {
         $img = imagecreatefromjpeg($source);
         if ($img === false) return ['error' => "Error al cargar la imagen JPEG."];
         else {
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            if(imagewebp($avatar, $imgWEBP, 100)) {
               imagedestroy($img);
               imagedestroy($avatar);
               // BORRAMOS LA ORIGINAL
               unlink($source);
            } else return ['error' => "Error al convertir la imagen a WebP."];
         }
      } else return ['error' => "La imagen de origen no existe."];
      //
      return ['error' => 'success'];
   }
   /*
   deleteFile()
    */
   public function deleteFile($file) {
      unlink(TS_UPLOADS . $file);
      return true;
   }
   /*
   uploadImagen()
    */
   public function uploadImagen($params) {
      global $tsCore;
      // User agent
      $useragent = $tsCore->getUserAgent();
      // SERVIDOR
      $servidor = $this->servers[$this->server];
      // Autorizar conexión
      $headers = ['Authorization: Client-ID 318cdea21b8f8c0'];
      // Abrir conexión
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
      curl_setopt($ch, CURLOPT_URL, $servidor);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // RESULTADO
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
   }
   /*
   setParams()
    */
   public function setParams($url) {
      switch ($this->server) {
         case 'imgur':
            $img = file_get_contents($url);
            return ['image' => base64_encode($img)];
         break;
      }
   }
   /**
    * @name getImagenUrl($html)
    * @access public
    * @param string
    * @return string
    * @version 1.1
    */
   public function getImagenUrl($code) {
      //
      switch ($this->server) {
         case 'imgur':
            global $tsCore;
            //
            $image_data = $tsCore->setJSON($code, 'decode');
            $src = $image_data->data->link;
            return $src;
         break;
      }
   }
   /**
    * Function: Determinar sexo del usuario
    * @author Miguel92
    * @copyright 2020 
   */
   function sexuser() {
      global $tsUser;

      $query = db_exec([__FILE__, __LINE__], 'query', "SELECT user_sexo FROM u_perfil WHERE user_id = {$tsUser->uid} LIMIT 1");
      $data = db_exec('fetch_assoc', $query);

      return $data;
   }

   // USAMOS GRAVATAR
   function getGravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = []) {
      $url = 'https://www.gravatar.com/avatar/';
      $url .= md5( strtolower( trim( $email ) ) );
      $url .= "?s=$s&d=$d&r=$r";
      if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val ) $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
      }
      return $url;
   }
   # ===================================================
   # PORTADA
   # * SubirPortada() :: Subimos la portada
   # * cropAvatarPortada() :: Cortamos la imagen
   # ===================================================
   public function SubirPortada() {
      $this->for = 'portada';
      $this->type = 3;
      return $this->newUpload(3);
   }
   public function cropAvatarPortada($key = NULL){
      $source = TS_UPLOADS . "{$this->prefix}{$_POST['key']}.{$_POST['ext']}";
      $size = getimagesize($source);
      // COORDENADAS
      $mn = $this->image_size_min;
      $mx = $this->image_size_max;
      // TAMANOS
      $_tw = $mn['w']; 
      $_th = $mn['h'];
      $_w = $mx['w']; 
      $_h = $mx['h'];
      // CREAMOS LA IMAGEN DEPENDIENDO EL TIPO
      switch($size['mime']){
         case 'image/jpeg':
         case 'image/jpg':
            $img = imagecreatefromjpeg($source);
         break;
         case 'image/gif':
            $img = imagecreatefromgif($source);
         break;
         case 'image/png':
            $img = imagecreatefrompng($source);
         break;
      }
      if(!$img) return array('error' => 'No pudimos crear tu portada...');
      //
      $width = imagesx($img);
      $height = imagesy($img);
      $arr = [
         'big' => [1200, 600],
         'portada' => [356, 244],
         'thumb' => [178, 122]
      ];
      $lvl = 0;
      foreach ($arr as $key => $data) {
         $nuevoAncho = ($width > $height) ? $data[0] : ($data[1] / $height) * $width;
         $nuevoAlto = ($width > $height) ? ($data[0] / $width) * $height : $data[1];
         $i[$key] = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
         imagecopyresampled($i[$key], $img, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $width, $height);
         // GUARDAMOS...      
         $lvl += 1;
         $root = TS_PORTADAS . "/cover{$lvl}_{$_POST['key']}.{$_POST['ext']}";
         imagejpeg($i[$key], $root, 80);
      }
      // CLEAR*/
      imagedestroy($img);
      imagedestroy($i['big']);
      imagedestroy($i['portada']);
      imagedestroy($i['thumb']);
      // BORRAMOS LA ORIGINAL
      unlink($source);
      //
      return ['error' => 'success'];
   }
}
