<?php
namespace Base;
use \Base\Mytpl;
#这里可以不继承Mytpl
class Controller {

	//返回实例
	public function assign($key,$val){
		Mytpl::assign($key,$val);
	}

	public function display($path=''){
		Mytpl::display($path);
	}

	//中间页面
	public  function redirect($jumpUrl='http://www.baidu.com',$msg='对不起,您访问的页面不存在',$waitSecond=2)
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