<?php
namespace Base;
class Route{
	public static function parse($pathinfo)
	{
		if( $pathinfo ){
			//pathinfo 模式
			$arr   = explode('/', trim($pathinfo,'/') );
			$count = count( $arr );
			if( $count == 1){
				$array = array('app'=>$arr[0],'module'=>'Index','action'=>'index');
			}else if( $count == 2){
				$array = array('app'=>$arr[0],'module'=>Ucfirst($arr[1]),'action'=>'index');
			}else{
				$array = array('app'=>$arr[0],'module'=>Ucfirst($arr[1]),'action'=>$arr[2]);
			}
		}else{
			//普通模式
			//$array = array('app'=>trim(APP_NAME,'/'),'module'=>'Index','action'=>'index');
			die('对不起,请使用pathinfo模式,eg:www.xxx.com/Home/Demo/test?id=1&name=zhangsan,Home为项目名称 Demo为模型名 test为方法名 :(');
		}
		return $array;
	}
}