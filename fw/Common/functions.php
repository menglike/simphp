<?php
	/**
	 * 该文件包含框架所有的公共函数
	 *
	 */
	function dump( $mixed ){
		echo "<pre>";
		var_dump( $mixed );
		echo "</pre>";
	}
	
	//开启调试模式
	function debug( $state ){
		if( $state  ){
			global $debug;	
			$debug = 1;
		}
	}

	function http_curl($url , $reqType='get', $resType='json' , $reqData=''){
		if( in_array($resType,array('json','xml','html') ) ){
			die('不存在的返回类型');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if( $reqData ){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $reqData);
		}
		$out = curl_exec( $ch );
		if( curl_errno( $ch ) ){
			return curl_error( $ch );
		}
		curl_close( $ch );
		if($resType == 'json'){
			return json_decode( $out ,true);
		}elseif($resType == 'xml'){
			return json_decode( json_encode(simplexml_load_string( $out )),true );
		}elseif($resType == 'html'){
			return $out;
		}
	}

	/*快速实例化模型*/
	function M( $module ){
		if(file_exists( APP.'/model/'.$module.'Model.class.php' )){
			$moduleModel = '\\Base\\Db\\'.$module.'Model';
			return new $moduleModel;
		}
		else{
			die(APP.'/model/'.$module.'Model.class.php文件不存在，请先创建');
		}
	}
	
	//获取特定位数的随机码
	function getRandCode($num = 6)
	{
		$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr( str_shuffle($str) ,0,$num);
	}

	