<?php
namespace org\opencomb\loader ;

use org\opencomb\platform\service\ServiceFactory;
use org\jecat\framework\mvc\controller\Request;
use org\jecat\framework\system\AccessRouter;

class Loader
{
	const version = '0.1.0.0' ;
	
	const default_platform_version = '0.3.2.0' ;
	const default_framework_version = '0.7.1.0' ;
	
	public function __construct()
	{
		$this->loadServiceSettings() ;
	}
	
	public function launch()
	{
		// 创建服务
		if( !$arrServiceSetting =& $this->serviceSetting($_SERVER['HTTP_HOST']) )
		{
			throw new \Exception('requesting service is invalid: '.$_SERVER['HTTP_HOST']) ;
		}
		
		// 加载 framework / platform
		require_once \org\opencomb\platform\FRAMEWORK_FOLDER.'/'.$arrServiceSetting['framework_version'].'/jc.init.php' ;
		require_once \org\opencomb\platform\PLATFORM_FOLDER.'/'.$arrServiceSetting['platform_version'].'/oc.init.php' ;

		// 创建请求的服务
		ServiceFactory::singleton()->create($arrServiceSetting) ;
		
		// 根据路由设置创建控制器 并 执行
		$aController = AccessRouter::singleton()->createRequestController(Request::singleton()) ;
		if($aController)
		{
			$aController->mainRun() ;
		}
		else
		{
			header("HTTP/1.0 404 Not Found");
			echo "<h1>Page Not Found</h1>" ;
		}
	}
	
	private function loadServiceSettings()
	{
		$sServiceSettingFile = \org\opencomb\platform\SERVICES_FOLDER.'/settings.inc.php' ;
	
		// load domain settings
		if( !is_file($sServiceSettingFile) )
		{
			// domains missing or broken, rebuild it
			if( $hServices = opendir(\org\opencomb\platform\SERVICES_FOLDER) )
			{
				while($sFilename=readdir($hServices))
				{
					if( $sFilename=='.' or $sFilename=='..')
					{
						continue ;
					}
					if( is_dir(\org\opencomb\platform\SERVICES_FOLDER.'/'.$sFilename) )
					{
						$this->arrServiceSettings[$sFilename] = array(
								'domains' => array( $sFilename==='default'? '*': $sFilename ) ,
						) ;
					}
				}
				closedir($hServices) ;
					
				if( !file_put_contents($sServiceSettingFile,'<?php return $arrServiceSettings = '.var_export($this->arrServiceSettings,true).';') )
				{
					throw new \Exception('can not write file: '.$sServiceSettingFile) ;
				}
			}
		}
		else
		{
			$this->arrServiceSettings = include $sServiceSettingFile ;
	
			if(!is_array($this->arrServiceSettings))
			{
				throw new \Exception($sServiceSettingFile."文件遭到了损坏，删除该文件后，系统会自动重建。") ;
			}
		}
	}

	private function & serviceSetting($sHost)
	{
		if(isset($this->arrServiceSettings[$sHost]))
		{
			$this->arrServiceSettings[$sHost]['name'] = $sHost ;

			// 服务数据目录路径
			$this->arrServiceSettings[$sHost]['folder_name'] = $sHost ;
			$this->arrServiceSettings[$sHost]['folder_path'] = \org\opencomb\platform\SERVICES_FOLDER . '/' . $sHost ;
			
			// framework/platform 的版本
			if(empty($this->arrServiceSettings[$sHost]['framework_version']))
			{
				$this->arrServiceSettings[$sHost]['framework_version'] = self::default_framework_version ;
			}
			if(empty($this->arrServiceSettings[$sHost]['platform_version']))
			{
				$this->arrServiceSettings[$sHost]['platform_version'] = self::default_platform_version ;
			}
			return $this->arrServiceSettings[$sHost] ;
		}
		else
		{
			foreach($this->arrServiceSettings as $sServiceFolder=>&$arrServiceInfo)
			{
				foreach($arrServiceInfo['domains'] as &$sDomain)
				{
					if(fnmatch($sDomain,$sHost))
					{
						$arrServiceInfo['name'] = $sServiceFolder ;
						
						// 服务数据目录路径
						$arrServiceInfo['folder_name'] = $sServiceFolder ;
						$arrServiceInfo['folder_path'] = \org\opencomb\platform\SERVICES_FOLDER . '/' . $sServiceFolder ;
						
						// framework/platform 的版本
						$arrServiceInfo['framework_version'] = self::default_framework_version ;
						$arrServiceInfo['platform_version'] = self::default_platform_version ;
						return $arrServiceInfo ;
					}
				}
			}

			$arrService = null ;
			return $arrService ;
		}
	}


	private $arrServiceSettings = array() ;
}

?>