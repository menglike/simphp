<?php
namespace Base;
class Mytpl {
	static $left_delimiter  = '{';
	static $right_delimiter = '}';
	static $tmp = '';
	static $val = '';
	static $arr = array();

	//分配变量
	public static function assign($key,$value){
		self::$arr[] = array( $key,$value );  
	}

	//展示页面
	public static function display($path)
	{
		$viewTpl = APP.'/view/'.$path.'.html';
		$md5 = md5($viewTpl);
		$cacheFile = PROJECT.'/runtime/cache/filecache/'.$md5.'.php';
		if( !empty(self::$arr) ){
			foreach(self::$arr as $k=>$v){
				${ $v[0] } = $v[1];
			}
		}
		if( !file_exists($viewTpl) ) die('<hr/>请先创建'.$viewTpl.'文件:(');

		//关闭缓存 或者 缓存文件不存在 或者 缓存时间过期 都生成新的一份缓存
		if( !file_exists($cacheFile) || CACHESTART == 0 || (CACHESTART && time()-filemtime($viewTpl)>CACHETIME) ){
			$template  =  file_get_contents($viewTpl)  ;

			/* 这里正则匹配 做个简单的模板引擎 */	
			preg_match_all('/\{include (.*)\}/',$template,$match);
			$tpl = $template;
			foreach($match as $k=>$v){
				$content = file_get_contents(APP."/view/".$match[1][$k].".html");
				$tpl     = preg_replace('/\{include '.str_replace('/','\\/',$match[1][$k]).'}/',$content,$tpl); 
			}
			$uri  = strpos('index.php',$_SERVER['SCRIPT_NAME']) !==false ? $_SERVER['SCRIPT_NAME'] : str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
			$tpl  = preg_replace('/\\'.self::$left_delimiter.'(\\$[a-zA-Z_][a-zA-Z0-9_]+)\\'.self::$right_delimiter.'/','<?php if(isset(\\1) && !empty(\\1))  echo \\1; else die(\'模板中变量\\1不存在:(\'); ?>',$tpl);
			$tpl  = preg_replace('/__PUBLIC__/','http://'.$_SERVER['HTTP_HOST'].'/'.trim($uri,'/').'/public/'.trim(APP_NAME,'/'),$tpl);

			//生成缓存模板
			if( !is_writable(CACHEDIR) ) die('对不起,'.CACHEDIR.'没有写入权限:(');
			touch($cacheFile,0777);
			file_put_contents($cacheFile,$tpl);
			require $cacheFile;
			self::$arr = null; //清空
			return;
		}
		require($cacheFile);
		return;
	}
}

