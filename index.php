<?php
$sPhpVersion = PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION.'.'.PHP_RELEASE_VERSION;
if(version_compare($sPhpVersion,'5.3.0')<0){
	require_once 'PhpVersionError.php';
	exit();
}

// 默认的时区
date_default_timezone_set('Asia/Shanghai') ;

ini_set('display_errors',1) ;
error_reporting(E_ALL^E_STRICT) ;

require_once __DIR__.'/common.php';
