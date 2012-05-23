<?php
namespace org\opencomb\loader ;

// 默认的时区
date_default_timezone_set('Asia/Shanghai') ;

ini_set('display_errors',1) ;
error_reporting(E_ALL^E_STRICT) ;

// 配置目录
define('org\\opencomb\\platform\\ROOT',__DIR__) ;
define('org\\opencomb\\platform\\EXTENSIONS_FOLDER',\org\opencomb\platform\ROOT.'/extensions') ;
define('org\\opencomb\\platform\\EXTENSIONS_URL','extensions') ;
define('org\\opencomb\\platform\\SERVICES_FOLDER',\org\opencomb\platform\ROOT.'/services') ;
define('org\\opencomb\\platform\\PUBLIC_FILES_FOLDER',\org\opencomb\platform\ROOT.'/public/files') ;
define('org\\opencomb\\platform\\PUBLIC_FILES_URL','public/files') ;
define('org\\opencomb\\platform\\FRAMEWORK_FOLDER',\org\opencomb\platform\ROOT.'/framework') ;
define('org\\opencomb\\platform\\PLATFORM_FOLDER',\org\opencomb\platform\ROOT.'/platform') ;

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


