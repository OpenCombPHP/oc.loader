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

// 在不同环境下，仅需要修改此文件即可。因此将VFS放在此文件中。
require_once __DIR__.'/vfs/VFSWrapper.php';
require_once __DIR__.'/vfs/VirtualFileSystem.php';
require_once __DIR__.'/vfs/IPhysicalFileSystem.php';
require_once __DIR__.'/vfs/LocalFileSystem.php';
require_once __DIR__.'/vfs/SaeStorageFileSystem.php';
if( defined('SAE_TMP_PATH') ){
	\org\jecat\framework\fs\vfs\VFSWrapper::vfs('ocfs')->mount(
		'oc/',
		new \org\jecat\framework\fs\vfs\SaeStorageFileSystem('ocsaefile')
	) ;
}
