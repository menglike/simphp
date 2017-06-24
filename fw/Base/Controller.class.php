<?php
namespace Base;
class Controller{
		const WAIT = 2;
		public function __constuct( $module, $action)
		{
			// parent::__construct( $module, $action );
		}

		//返回实例
		public function assign($key,$val){
			\Base\Mytpl::assign($key,$val);
		}

		public function display($path=''){
			if( empty($path) ) die('请指定模板:(');
			\Base\Mytpl::display($path);
		}

		//中间页面
		public  function redirect($jumpUrl='http://www.baidu.com',$msg='对不起,您访问的页面不存在',$waitSecond=self::WAIT,$status='success')
		{
			$url = $this->dealJumpUrl($jumpUrl);
			$type = $status == 'success' ? 'success': 'error';
			require ZENDFRAME.'/Tpl/redirect.html';
		}

		//判断跳转到应用内
		private function dealJumpUrl($jumpUrl)
		{
			$urlArr = explode('|',$jumpUrl);
			$urlNum = count($urlArr);
			switch($urlNum){
				case 1 :
					return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'/'.APPLICATION.'/'.MODULE.'/'.$urlArr[0];
					break;
				case 2 :
					return  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'/'.APPLICATION.'/'.$urlArr[0].'/'.$urlArr[1];
					break;
				case 3 :
					return  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'/'.$urlArr[0].'/'.$urlArr[1].'/'.$urlArr[2];
					break;
			}
		}
		
}