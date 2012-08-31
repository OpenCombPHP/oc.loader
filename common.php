<?php
require_once __DIR__.'/defines.php';

// 检查是否完成安装
if( !is_dir(\org\opencomb\platform\SERVICES_FOLDER) and is_file(__DIR__.'/setup/setup.php') )
{
	Header("Location:setup/setup.php");
	echo "<a>Install ... </a>" ;
	exit() ;
}

// 初始化 jcat 框架
require_once __DIR__.'/Loader.php' ;
$aLoader = new \org\opencomb\loader\Loader() ;
return $aLoader ;
