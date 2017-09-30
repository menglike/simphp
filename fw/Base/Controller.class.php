<?php
namespace Base;
class Controller{
		public function __constuct( $module, $action)
		{
			parent::__construct( $module, $action );
		}

		//返回实例
		public function assign($key,$val){
			\Base\Mytpl::assign($key,$val);
		}

		public function display($path=''){
			if( empty($path) ) die('<hr />请指定模板:(');
			\Base\Mytpl::display($path);
		}

		//中间页面
		public  function success($jumpUrl='http://www.baidu.com',$msg='对不起,您访问的页面不存在',$waitSecond=2)
		{
			$type = 'success';
			require ZENDFRAME.'/Tpl/redirect.html';
		}

		//中间页面
		public  function error($jumpUrl='http://www.baidu.com',$msg='对不起,您访问的页面不存在',$waitSecond=2)
		{
			$type = 'error';
			require ZENDFRAME.'/Tpl/redirect.html';
		}

		
}