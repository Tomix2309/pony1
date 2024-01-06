<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty combine function plugin
 *
 * Type:    function<br>
 * Name:    combine<br>
 * Date:    September 5, 2015
 * Purpose: Combine content from several JS or CSS files into one
 * Input:   string to count
 * Example: {combine input=$array_of_files_to_combine output=$path_to_output_file use_true_path=true age=$seconds_to_try_recombine_file}
 *
 * @author Gorochov Ivan <dead23angel at gmail dot com>
 * @version 1.0
 * @param array
 * @param string
 * @param int
 * @return string
 */
function smarty_function_phpost_style($params, &$smarty){
  $debug = DEB ? "?v=".date("d-m-Y H:i:s"):"";
  $final = '<link rel="stylesheet" href="'.SYSURL.'/dist/'.$params['name'].'.css'.$debug.'" type="text/css">';

  if (!file_exists(SYSPATH."/dist/".$params['name'].".css") or DEB) {

    $template = $smarty->fetch($smarty->getTemplateDir()[0]."/".$params['file']);
    $regex = array(
    "`^([\t\s]+)`ism"=>'',
    "`^\/\*(.+?)\*\/`ism"=>"",
    "`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
    "`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
    "`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
    );
    $template = preg_replace(array_keys($regex),$regex,$template);
    $template = str_replace('; ',';',str_replace(' }','}',str_replace('{ ','{',str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),"",preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$template)))));
    $dirDist = SYSPATH."/dist/";
    if ( ! is_writable( $dirDist ) ) {
          rmdir($dirDist);
          mkdir($dirDist, 0777);
    }
    $fileLocation = $dirDist . $params['name'].".css";
    $file = fopen($fileLocation, "w");
    $content = $template;
    fwrite($file,$content);
    fclose($file);

    $final = '<link rel="stylesheet" href="'.SYSURL.'/dist/'.$params['name'].'.css'.$debug.'" type="text/css">';

  }
  return $final;
}
