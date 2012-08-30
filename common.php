<?php
// 配置目录
define('org\\opencomb\\platform\\ROOT',__DIR__) ;
if( defined('SAE_TMP_PATH') ){
	define('org\\opencomb\\platform\\DATAROOT','ocfs://oc') ;
}else{
	define('org\\opencomb\\platform\\DATAROOT',__DIR__) ;
}
define('org\\opencomb\\platform\\EXTENSIONS_FOLDER',\org\opencomb\platform\ROOT.'/extensions') ;
define('org\\opencomb\\platform\\EXTENSIONS_URL','extensions') ;
define('org\\opencomb\\platform\\SERVICES_FOLDER',\org\opencomb\platform\DATAROOT.'/services') ;
define('org\\opencomb\\platform\\PUBLIC_FILES_FOLDER',\org\opencomb\platform\DATAROOT.'/public/files') ;
define('org\\opencomb\\platform\\PUBLIC_FILES_URL','public/files') ;
define('org\\opencomb\\platform\\FRAMEWORK_FOLDER',\org\opencomb\platform\ROOT.'/framework') ;
define('org\\opencomb\\platform\\FRAMEWORK_URL','framework') ;
define('org\\opencomb\\platform\\PLATFORM_FOLDER',\org\opencomb\platform\ROOT.'/platform') ;
define('org\\opencomb\\platform\\PLATFORM_URL','platform') ;

if( defined('SAE_TMP_PATH') ){
	// 在不同环境下，仅需要修改此文件即可。因此将VFS放在此文件中。
	require_once __DIR__.'/vfs/VFSWrapper.php';
	require_once __DIR__.'/vfs/VirtualFileSystem.php';
	require_once __DIR__.'/vfs/IPhysicalFileSystem.php';
	require_once __DIR__.'/vfs/LocalFileSystem.php';
	require_once __DIR__.'/vfs/SaeStorageFileSystem.php';

	\org\jecat\framework\fs\vfs\VFSWrapper::vfs('ocfs')->mount(
		'oc/',
		new \org\jecat\framework\fs\vfs\SaeStorageFileSystem('ocsaefile')
	) ;
}

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
