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
			}else if( $count == 3){
				$array = array('app'=>$arr[0],'module'=>Ucfirst($arr[1]),'action'=>$arr[2]);
			}
		}else{
			$m = !empty($_GET['m']) ? $_GET['m'] : 'Index';
			$c = !empty($_GET['c']) ? $_GET['c'] : 'index';
			//普通模式
			$array = array('app'=>trim(APP_NAME,'/'),'module'=> $m,'action'=>$c);
		}
		return $array;
	}
}