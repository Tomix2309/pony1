<?php if ( ! defined('TS_HEADER')) exit('No se permite el acceso directo al script');
/**
 * @name    c.jsondb.php
 * @author Miguel92
 * @copyright 2020-2024
*/

class tsJson {
   
   private $style = '';

   public function getFile_Json($param) {      
      # Buscamos el archivo .json
      $json_rute = TS_SETTINGS . $param . '.json';
      $json = json_decode(file_get_contents($json_rute), true);
      return $json;
   }
   # Reemplazamos la #ID# por id de la imagen
   function replaceID($id, $url, $page) {
      # Buscamos el archivo .json
      $json = $this->getFile_Json('settings');
      # Creamos la ruta completa de la imagen
      $url = str_replace('#ID#', $id, $url);
      if($page == 'pexels') {
         # Seleccionamos los datos de pexels
         $p = $json['params'];
         # Añadimos los parámatros
         $url .= '?auto=' .$p['auto'] . '&cs=' .$p['cs'] . '&dpr=' .$p['dpr'] . '&fit=' .$p['fit'];
      }
      $url .= ($page == 'pexels') ? '&h='.$json['background']['height'].'&w='.$json['background']['width'] : '/' . $json['background']['width'].'x'.$json['background']['height'];
      # Retornamos
      return $url;
   }
   # Extraemos toda la información del archivo ADMIN
   function getAdminInfo() {
      # Buscamos el archivo
      $json = $this->getFile_Json('settings');
      # Asignamos los valores
      $arr = $json['background'];
      foreach ($arr as $k => $ty) {
         if($arr == 'type' || $arr == 'id') continue;
         $data[$k] = $json['background'][$k];
      }
      # Que página usa?
      $page = $json['background']['type'];
      $data['web'] = $page;
      $data['id'] = $json['background']['id'];      
      # Retornamos
      return $data;
   }
   # Agregamos la información a la página para renderizarlo
   function getAddInfo() {
      # Buscamos el archivo
      $json = $this->getFile_Json('settings');
      # Tipo
      $type = $json['background']['type'];
      # Que página?
      $data['web'] = $type;
      $data['id'] = $json['background']['id'];
      # Creamos la ruta de la imagen
      $data['url'] = $this->replaceID($data['id'], $json[$type]['url'], $type);
      $css = $json['background'];
      foreach ($css as $k => $y) {
         if($k == 'type' || $k == 'id' || $k == 'width' || $k == 'height' || $k == 'img') continue;
         $style .= "background-{$k}: $css[$k]!important;";
      }
      # Para retornar datos armados
      $data['css'] = $style;
      # Retornamos
      return $data;
   }
   # Guardamos todo el el archivo
   function save_json($param) {
      # Buscamos el archivo
      $file_admin = TS_SETTINGS . "settings.json";
      $j = array();
      if ( file_exists($file_admin) ){
         $j = (array)json_decode(file_get_contents($file_admin));
         unlink($file_admin);
      }  else {
         # Si no existe creamos uno! No preguntamos.
         $fichero = TS_SETTINGS . "backup.json";
         $nuevo_fichero = TS_SETTINGS . "settings.json";
         if (!copy($fichero, $nuevo_fichero)) echo "Error al copiar $fichero...\n";
      }
      # Añadimos los nuevos datos
      foreach ($_POST as $k => $v) {
         $PostAll[$k] = $_POST[$k];
      }
      $j[$param] = $PostAll;
      # Insertamos los datos al archivo json
      file_put_contents($file_admin, json_encode($j));
      //unset($j);
      # Retornamos un mensaje
      return '1: Los cambios fuerón aplicados!';
   }
   function getSeo() {
      # Buscamos el archivo
      $json = $this->getFile_Json('settings');
      #
      foreach ($json['seo'] as $key => $value) {
         $data[$key] = $json['seo'][$key];
      }
      # Retornamos
      return $data;
   }
   
   ### CONFIGURACIONES PARA EL USUARIOS NORMAL ###

   # Extraemos toda la información del archivo USER
   function getInfoPortada(){
      global $tsCore, $tsUser;
      $json = $this->getFile_Json(trim($tsUser->nick));
      # ID
      $json['position'] = $json['portada']['position'];
      $json['repeat'] = $json['portada']['repeat'];
      $json['width'] = $json['portada']['width'];
      $json['height'] = $json['portada']['height'];
      $json['id_img'] = $json['portada']['id'];
      $json['web'] = $json['portada']['type'];
      # Retornamos
      return $json;
   }
   # Extraemos solo la id
   function Id_Portada($who){
      global $tsCore, $tsUser;
      $json = $this->getFile_Json(trim($tsUser->nick));
      echo $json[$who]['id'];
   }
   # Guardamos todo el el archivo
   function saveInfoPortada() {
      global $tsCore, $tsUser;
      $id = intval($_POST['pid']);
      if($tsUser->uid == $id){
      $sql = db_exec('fetch_assoc', db_exec(array(__FILE__, __LINE__), 'query', "SELECT user_name FROM u_miembros WHERE user_id = {$id}"));
         # Ahora lo agregaremos al achivo
         $file_user = TS_SETTINGS . trim($sql['user_name']) . ".json";
         //$j = json_decode($file_user, true);
         $j = array();
         if ( file_exists($file_user) ){
            $j = (array)json_decode(file_get_contents($file_user));
            unlink($file_user);
         } else {
            # Si no existe creamos uno! No preguntamos.
            $fichero = TS_SETTINGS . "create_new.json";
            $nuevo_fichero = TS_SETTINGS . trim($sql['user_name']) . ".json";
            if (!copy($fichero, $nuevo_fichero)) echo "Error al copiar $fichero...\n";
         }
         # Añadimos los nuevos datos
         $data['position'] = $_POST['position'];
         $data['repeat'] = $_POST['repeat'];
         $data['type'] = $_POST['sitio'];
         $data['width'] = $_POST['width'];
         $data['height'] = $_POST['height'];
         $data['id'] = $_POST['imagen'];
         $j['portada'] = $data;
         # Insertamos los datos al archivo json
         file_put_contents($file_user, json_encode($j));
         //unset($j);
         
         return '1: Los cambios fuerón aplicados!';
      } else return '0: Tu ID no es válido.';
   }
   # Fin del la clase
}