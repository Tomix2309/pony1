<?php

class getOpenGraph {
   
   function getUrlData($url, $raw=false) {
      $result = false;
      $contents = $this->getUrlContents($url);
      if (isset($contents) && is_string($contents)) {
         $title = null;
         $metaTags = null;
         $metaProperties = null;
         #
         preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );
         #
         if (isset($match) && is_array($match) && count($match) > 0) $title = strip_tags($match[1]);
         #
         preg_match_all('/<[\s]*meta[\s]*(name|property)="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
         
         if (isset($match) && is_array($match) && count($match) == 4) {
            $originals = $match[0];
            $names = $match[2];
            $values = $match[3];
            if (count($originals) == count($names) && count($names) == count($values)) {
               $metaTags = array();
               $metaProperties = $metaTags;
               if ($raw) {
                  $flags = (version_compare(PHP_VERSION, '5.4.0') == -1) ? ENT_COMPAT : ENT_COMPAT | ENT_HTML401;
                  for ($i=0, $limiti=count($names); $i < $limiti; $i++) {
                     $meta_type = ($match[1][$i] == 'name') ? 'metaTags' : 'metaProperties';
                     if ($raw) {
                        ${$meta_type}[$names[$i]] = array (
                           'html' => htmlentities($originals[$i], $flags, 'UTF-8'),
                           'value' => $values[$i]
                        );
                     } else {
                        ${$meta_type}[$names[$i]] = array (
                           'html' => $originals[$i],
                           'value' => $values[$i]
                        );
                     }
                  }
                  # for
               }
               # if raw
            }
            $result = array (
               'title' => $title,
               'metaTags' => $metaTags,
               'metaProperties' => $metaProperties,
            );
         }
      return $result;
   }

   function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0) {
      $result = false;
      $contents = @file_get_contents($url);
      if (isset($contents) && is_string($contents)) {
         preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);
         if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1) {
            if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections) return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
            $result = false;
         } else $result = $contents;
      }
      return $contents;
   }
}