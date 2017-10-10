<?php
namespace Base;
class Mytpl {
	
	static $left_delimiter  = '{'; #左分割符
	static $right_delimiter = '}'; #右分割符
	static $tmp = '';
	static $val = '';
	static $arr = array();

	//分配变量
	public static function assign($key,$value){
		self::$arr[] = array( $key,$value );  
	}

	//展示页面
	public static function display($path='')
	{
		if( !is_writable(CACHEDIR) ) die('对不起,'.CACHEDIR.'没有写入权限:(');

		if( $path === '' ) $path = MODULE.'/'.ACTION  ;
		$viewTpl   = APP.'/view/'.$path.'.html';
		if( !file_exists($viewTpl) ) die('<br/>文件不存在,请先创建'.$viewTpl.'文件:(');
		$md5       = md5($viewTpl);
		$cacheFile = PROJECT.'/runtime/cache/filecache/'.$md5.'.php';
		if( !empty(self::$arr) ){
			foreach(self::$arr as $k=>$v){
				${ $v[0] } = $v[1];
			}
		}

		if(!CACHESTART)
			//关闭缓存 生成新的编译文件  编译就是将部分标签替换成php代码
			if( !is_writable( dirname($compileFile) ) )  die(dirname($compileFile).' 编译目录不可写:(');
		
		if(CACHESTART){
			if( !is_writable( dirname($cacheFile) ) )    die(dirname($cacheFile).' 缓存目录不可写:(');

			//开启缓存 缓存文件不存在 或者 缓存时间过期 或者开启调试模式 都生成(旧的存在就必须要删掉)新的一份缓存
			if( !file_exists($cacheFile) || time()-filemtime($viewTpl)>CACHETIME  || DEBUG){
				
				//先删除
				if( file_exists($cacheFile) ) unlink($cacheFile);
				//新生成缓存
				//获取模板文件内容
				$tpl  =  file_get_contents($viewTpl);
				//1.替换include ,匹配出要替换的模板
				$tpl = self::replace_include($tpl);
				//去掉index.php
				$uri  = strpos('index.php',$_SERVER['SCRIPT_NAME']) === false ? $_SERVER['SCRIPT_NAME'] : str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
				$tpl  = preg_replace('/\\'.self::$left_delimiter.'(\\$[a-zA-Z_][a-zA-Z0-9_]+)\\'.self::$right_delimiter.'/','<?php if(isset(\\1) && !empty(\\1))  echo \\1; ?>',$tpl);
				$tpl  = preg_replace('/__PUBLIC__/','http://'.$_SERVER['HTTP_HOST'].'/'.trim($uri,'/').'/public/'.trim(APP_NAME,'/'),$tpl);

				touch($cacheFile,0777);
				file_put_contents($cacheFile,$tpl);
				require $cacheFile;
				self::$arr = null; //清空
				return;
			}else{
				require $cacheFile;
				return;
			}
		}
		
		
	}

	//递归 include 包含
	public static function  replace_include($tpl){
		preg_match_all('/\\'.self::$left_delimiter.'include\s(.*)\\'.self::$right_delimiter.'/',$tpl,$match);
		foreach($match as $k=>$v){
			if(!file_exists(APP."/view/".$match[1][$k].".html") ) die(APP."/view/".$match[1][$k].".html 文件不存在");
			$content = file_get_contents(APP."/view/".$match[1][$k].".html");
			//正则替换
			$tpl     = preg_replace('/\\'.self::$left_delimiter.'include\s'. str_replace('/','\\/',$match[1][$k]).'\\'.self::$right_delimiter.'/',$content,$tpl); 
		}
		if(preg_match('/include/',$tpl)){
			$content = '';
			$match = array();
			return self::replace_include($tpl);
		}else{
			return $tpl;
		}
	}
}

