<?php 

define('USEVERSION', '2.8.34');

define('MOBILEDETECT', TS_LIBS . 'mobiledetect' . SEPARATOR);
define('MOBILECACHE', MOBILEDETECT . 'Cache' . SEPARATOR);
define('MOBILEEXCEPTION', MOBILEDETECT . 'Exception' . SEPARATOR);

if(USEVERSION === '4.8.04') {

	// 1. Include composer's autoloader
	require MOBILEDETECT . 'MobileDetect.php';
	require MOBILECACHE . 'Cache.php';
	require MOBILECACHE . 'CacheException.php';
	require MOBILECACHE . 'CacheItem.php';
	require MOBILEEXCEPTION . 'MobileDetectException.php';

	// Here you can inject your own caching system.
	$detect = new MobileDetect();

} else {

	require MOBILEDETECT . 'MobileDetectOld.php';
	// Here you can inject your own caching system.
	$detect = new Mobile_Detect();

}
