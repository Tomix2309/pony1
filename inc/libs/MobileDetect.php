<?php 

define('MOBILEDETECT', TS_LIBS . 'mobiledetect' . SEPARATOR);
define('MOBILECACHE', MOBILEDETECT . 'Cache' . SEPARATOR);
define('MOBILEEXCEPTION', MOBILEDETECT . 'Exception' . SEPARATOR);

// 1. Include composer's autoloader
require MOBILEDETECT . 'MobileDetect.php';
require MOBILECACHE . 'Cache.php';
require MOBILECACHE . 'CacheException.php';
require MOBILECACHE . 'CacheItem.php';
require MOBILEEXCEPTION . 'MobileDetectException.php';

//use Detection\MobileDetect;
// Here you can inject your own caching system.
$detect = new MobileDetect();