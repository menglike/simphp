<?php
namespace Base;
class Simphp {
	public static function run()
	{
		  \Base\Structure::create(); //创建项目目录

		  //过滤所有用户传递过来参数
		  if($_POST || $_COOKIE  || $_GET || $_SERVER){
		  	$server = array($_POST,$_GET,$_COOKIE,$_SERVER);
		  	foreach($server as $k=>$v)
		  	  self::secureFilter($v);
		  }
		  require ZENDFRAME.'/Conf/config.php';	//加载框架默认的配置文件

		  $pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
		  $arr = \Base\Route::parse($pathinfo); //解析url

		  //加载应用自己的配置文件
		  if( file_exists(APP.'/config.php') )   $configArr = require(APP.'/config.php');
		  if( !empty($configArr) ){
		  	foreach($configArr as $k=>$v)
		  		define($k,$v);//这里需要对$k，$v做判断
		  }

		  // 访问应用
		  $app    = $arr['app'];
		  // 访问模块名
		  $module = $arr['module'];
		  // 访问方法名
		  $action = $arr['action'];
		  define('MODULE',$module);
		  define('ACTION',$action);
		  
		  $moduleName = $module.'Controller';
		  
		     file_exists(APP.'/controller/'.$module.'.class.php')      ? require_once(APP.'/controller/'.$module.'.class.php')      : die(APP.'/controller/'.$module.'.class.php 文件不存在:(');
		  if(file_exists(APP.'/model/'     .$module.'Model.class.php') ) require_once(APP.'/model/'.     $module.'Model.class.php') ;
		  $controlName = '\\'.ucfirst(trim(APP_NAME,'/')).'\\Controller\\'.$moduleName;

		  require PROJECT.'/common/functions.php';	//加载项目的函数文件,不允许方法名重名
		  \Base\Filter::sql_xss_filter();
		  $obj = new $controlName($module,$action);
		  $obj->$action();
	}	

	#安全过滤函数 过滤sql注入 xss
	public static function secureFilter($params)
	{

	}
}