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

	//前端展示页面
	public static function display($path)
	{
		$viewTpl   = APP.'/view/'.$path.'.html';
		$md5       = md5($viewTpl);
		$cacheFile = PROJECT.'/runtime/cache/filecache/'.$md5.'.php';
		if( !empty(self::$arr) ){
			foreach(self::$arr as $k=>$v){
				${ $v[0] } = $v[1];
			}
		}
		if( !file_exists($viewTpl) ) die('请先创建'.$viewTpl.'文件:(');

		//开启模板缓存： （缓存文件不存在）  或者 （缓存时间过期） 都生成新的一份缓存
		//未开启模缓存：  也需要走模板引擎-》php代码
		if(  CACHESTART === 0 || (CACHESTART && !file_exists($cacheFile)) ||  (CACHESTART && time()-filemtime($viewTpl)>CACHETIME) ){
			$template  =  file_get_contents($viewTpl);
			/* 这里正则匹配 做个简单的模板引擎 */
			global $tpl;
			self::moreInclude($template);
			$uri  = strpos('index.php',$_SERVER['SCRIPT_NAME']) !== false ? $_SERVER['SCRIPT_NAME'] : str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
			$tpl  = preg_replace('/\\'.self::$left_delimiter.'(\\$[a-zA-Z_][a-zA-Z0-9_]+)\\'.self::$right_delimiter.'/','<?php if(isset(\\1) && !empty(\\1))  echo \\1; else die(\'模板中变量\\1不存在:(\'); ?>',$tpl);
			$tpl  = preg_replace('/__PUBLIC__/','http://'.$_SERVER['HTTP_HOST'].'/'.trim($uri,'/').'/public/'.trim(APP_NAME,'/'),$tpl);

			//生成缓存模板
			if( !is_writable(CACHEDIR) ) die('对不起,'.CACHEDIR.'没有写入权限:(');
			touch($cacheFile,0777);
			file_put_contents($cacheFile,$tpl);
			require $cacheFile;
			unset($tpl,$template); //清空变量
			return;

		}
		require($cacheFile);
		return;
	}

	 static function moreInclude($template_content)
	{

		/*global $n;
		if($n==0){
			echo 0;
			echo '<hr />';
		}
		$n++;*/


		preg_match_all('/\{include (.*)\}/',$template_content,$match);

		/*if($n==3){
			echo 3;
			dump($match);
		}*/
		//这里需要处理 嵌套include的问题
		if( !empty($match[1]) ) {
			foreach ($match[1] as $k => $v) {

				$con = file_get_contents(APP . "/view/" . $match[1][$k] . ".html");
				$template_content = preg_replace('/\{include ' . str_replace('/', '\\/', $match[1][$k]) . '}/', $con, $template_content);

				/*if($n==1){
					dump($con);dump($match[1][$k]);
					echo '<hr />';
					echo $template_content;
				}

				if($n==2){
					echo 2;
					dump( $match[1][$k]);
					dump($con);
					echo '<hr />';
//					echo $template_content;
				}*/
				self::moreInclude($template_content);
			}
		}else{

			//当前模板中无 include 了
			global $tpl;
			$tpl = $template_content;
		}
	}
}

