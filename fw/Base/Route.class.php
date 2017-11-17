<?php
namespace Base;
class Route{
	public static function parse($pathinfo)
	{
		
		if( $pathinfo ){
			//pathinfo 模式
			$arr   = explode(URLDELIMITER, trim($pathinfo,'/') );
			$count = count( $arr );
			if( $count == 1){
				$array = array('app'=>$arr[0],'module'=>'Index','action'=>'index');
			}else if( $count == 2){
				$array = array('app'=>$arr[0],'module'=>Ucfirst($arr[1]),'action'=>'index');
			}else if( $count == 3){
				$array = array('app'=>$arr[0],'module'=>Ucfirst($arr[1]),'action'=>$arr[2]);
			}
		}else{
			$tmp = explode(URLDELIMITER,trim($_SERVER['REQUEST_URI'],'/'));
			$count = count($tmp);
			if( $count == 1){
				$array = array('app'=>$tmp[0],'module'=>'Index','action'=>'index');
			}else if( $count == 2){
				$array = array('app'=>$tmp[0],'module'=>Ucfirst($tmp[1]),'action'=>'index');
			}else if( $count == 3){
				$array = array('app'=>$tmp[0],'module'=>Ucfirst($tmp[1]),'action'=>$tmp[2]);
			}else{
				$array = array('app'=>$tmp[0],'module'=>Ucfirst($tmp[1]),'action'=>$tmp[2]);
				$get = array_splice($tmp,3);
				if(count($get)%2==1) die('GET 参数有错误');
				$_GET = null;
				foreach($get as $k=>$v){
					if($k%2==0) $_GET[ $get[$k] ] = $get[$k+1];
				}
			}
			//普通模式
			/*$m = !empty($_GET['m']) ? $_GET['m'] : 'Index';
			$c = !empty($_GET['c']) ? $_GET['c'] : 'index';
			$array = array('app'=>trim(APP_NAME,'/'),'module'=> $m,'action'=>$c);*/
		}
		return $array;
	}
}