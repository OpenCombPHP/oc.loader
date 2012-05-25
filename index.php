<?php
namespace org\opencomb\loader ;

// 默认的时区
date_default_timezone_set('Asia/Shanghai') ;

ini_set('display_errors',1) ;
error_reporting(E_ALL^E_STRICT) ;

require_once __DIR__.'/config.php';

// 检查是否完成安装
if( !is_dir(\org\opencomb\platform\SERVICES_FOLDER) and is_file(__DIR__.'/setup/setup.php') )
{
	echo "<a>Install ... </a>" ;
	exit() ;
}

// 初始化 jcat 框架
require __DIR__.'/Loader.php' ;
$aLoader = new Loader() ;
$aLoader->launch() ;


