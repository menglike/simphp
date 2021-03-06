<?php
//调试类
namespace Base;
class Debug{
	//定义静态成员属性
	static $startTime;
	static $endTime;
	static $msg;
	static $info;
	static $sql;
	static $startMem;
	static $endMem;

	// 定义添加调试消息  
	// $type 默认为调试信息
	static function addMsg( $message,$type=0 ){
		switch($type){
			case 0:
				self::$info[] = $message;
			break;
			case 1:
				self::$sql[] = $message;
			break;
		}
	}
	
	//展示调试消息
	static function showMsg(){
		$runTime =  round(self::$endTime - self::$startTime,4);
		if(count(self::$info)>0){
			self::$msg .= '[info]:';
			foreach(self::$info as $k=>$v){
				self::$msg .= $v.'<br />';	
			}
		}
		if(count(self::$sql)>0){
			self::$msg .= '[sql]:';
			foreach(self::$sql as $k=>$v){
				self::$msg .= $v.'<br />';	
			}
		}	

		self::$msg = "<div style='border:1px solid red;'>".self::$msg;
		self::$msg .= '开始时间:'.self::$startTime.'<br/>';
		self::$msg .= '结束时间:'.self::$endTime.'<br/>';
		self::$msg .= '<br />总共运行了 '.$runTime.' ms 微秒';
		self::$msg .= '<br />总消耗'.(self::$endMem -  self::$startMem).' bytes 内存</div>';
		echo self::$msg;
	}

	static function start(){
		self::$startTime = microtime(true);
		self::$startMem  = memory_get_usage();
	}	

	static function stop(){
		self::$endTime = microtime(true);
		self::$endMem  = memory_get_usage();
	}	
}