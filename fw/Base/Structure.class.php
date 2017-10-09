<?php
namespace Base;
class Structure{
	public static function create()
	{
		//要生成的目录
		$directory =  array(
			//文件目录|权限|提示信息
			array(APP,                                   0755, "应用目录 ".trim(APP_NAME,'/')." 创建成功<br />"),   //项目目录
			array(PROJECT.'/runtime',                    0755, "项目的临时目录 ".PROJECT.'/runtime'.              " 创建成功<br />"),   //项目的临时目录
			array(PROJECT.'/runtime/cache',              0755, "-项目的缓存目录 ".PROJECT.'/runtime/cache'.        " 创建成功<br />"),   //项目的缓存目录
			//array(PROJECT.'/runtime/cache/compile',      0777, "&nbsp;&nbsp;-项目的编译目录 ".PROJECT.'/runtime/cache/compile'." 创建成功<br />"),   //项目的编译目录(目录可写)
			array(PROJECT.'/runtime/cache/log',          0777, "&nbsp;&nbsp;-项目的日志目录 ".PROJECT.'/runtime/cache/log'.    " 创建成功<br />"),   //项目的日志目录(目录可写)
			array(PROJECT.'/runtime/cache/filecache',    0777, "&nbsp;&nbsp;-项目的文件缓存目录 ".PROJECT.'/runtime/cache/filecache'.    " 创建成功<br />"),   //项目的日志目录(目录可写)

			array(PROJECT.'/public/',                               0755, "项目的公共资源目录 ".   PROJECT.'/public'.                                 " 创建成功<br />"),   //项目的资源目录
			array(PROJECT.'/public/'.trim(APP_NAME,'/'),            0755, "&nbsp;&nbsp;-项目的资源目录 ".       PROJECT.'/public/'. trim(APP_NAME,'/').            " 创建成功<br />"),   //项目的资源目录
			array(PROJECT.'/public/'.trim(APP_NAME,'/').'/images',  0755, "&nbsp;&nbsp;-项目的资源images目录 ". PROJECT.'/public/'. trim(APP_NAME,'/').'/images' . " 创建成功<br />"),   //项目的资源目录
			array(PROJECT.'/public/'.trim(APP_NAME,'/').'/css',     0755, "&nbsp;&nbsp;-项目的资源css目录 ".    PROJECT.'/public/'. trim(APP_NAME,'/').'/css'    . " 创建成功<br />"),   //项目的资源目录
			array(PROJECT.'/public/'.trim(APP_NAME,'/').'/js',      0755, "&nbsp;&nbsp;项目的资源js目录 ".     PROJECT.'/public/'. trim(APP_NAME,'/').'/js'     . " 创建成功<br />"),   //项目的资源目录
			array(PROJECT.'/public/'.trim(APP_NAME,'/').'/uploads', 0777, "&nbsp;&nbsp;-项目的资源uploads目录 ".PROJECT.'/public/'. trim(APP_NAME,'/').'/uploads'. " 创建成功<br />"),   //项目的资源目录

			array(PROJECT.'/common',         0755, "项目的公共函数common目录 ".        PROJECT.'/common'.  " 创建成功<br />"),   //项目的资源目录
			array(PROJECT.'/extend',         0755, "项目的第三方扩展类extend目录 ".    PROJECT.'/extend'.  " 创建成功<br />"),   //项目的资源目录

			array(APP.'/controller',         0755, "项目 ".trim(APP_NAME,'/')." 应用的控制器目录 ".APP.'/controller'.  " 创建成功<br />"),   //项目的控制器目录
		  	array(APP.'/model',              0755, "项目 ".trim(APP_NAME,'/')." 应用的模型目录 ".  APP.'/model'.       " 创建成功<br />"),   //项目的模型目录
			array(APP.'/view',               0755, "项目 ".trim(APP_NAME,'/')." 应用的视图目录 ".  APP.'/view'.        " 创建成功<br />"),   //项目的视图目录
		);

		foreach($directory as $k=>$v){
			if( !file_exists($v[0]) ) {  //如果不存在目录
				if( mkdir( $v[0] , $v[1])){	 //创建目录
					echo $v[2];
					//todo 是否创建文件锁
				}
			}
		}
		//需要生成的文件
		$file  =  array(
			//文件名称|权限|提示
			//array(PROJECT.'/runtime/cache/log/error_log_'.date('Ymd').'.php' ,           0755, '项目错误日志文件'.PROJECT.'/runtime/cache/log/error_log_'.date('Ymd').'.php'."创建成功<br />"),   //项目目录
			//array(PROJECT.'/runtime/cache/log/log.php' ,                 0755, "项目日志文件".PROJECT.'/runtime/cache/log/log.php'."创建成功<br />"),   //项目目录
			
			array(PROJECT.'/common/functions.php' ,                      0755, "项目公共函数文件".PROJECT.'/common/functions.php'."创建成功<br />"),   //项目目录
			array(APP.    '/controller/Index.class.php' ,                0755, "项目默认控制器文件".APP.'/controller/Index.class.php'."创建成功<br />"),   //项目目录
			array(APP.'/config.php' ,                                    0755, "项目全局配置文件".APP.'/config.php'."创建成功<br />"),   //项目目录
		);
		//有写入内容的文件
		$writeContent_functions = <<<PA
<?php
/**
*项目中的所有公共函数
*/
function dump( \$arr ){
	echo "<pre>";
	var_dump( \$arr );
	echo "</pre>";
}
//获取特定位数的随机码
function getRandCode(\$num = 6)
{
	\$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	return substr( str_shuffle(\$str) ,0,\$num);
}
PA;
		$space = trim(APP_NAME,'/');
		$writeContent_index = '<?php
namespace '.ucfirst($space).'\\Controller;
use Base\\Controller;
class IndexController extends Controller{
	public function index(){
		echo "欢迎使用simplePHP框架!";
	}
}
';
		$writeContent_config = <<<PC
<?php
	//这里可以对应用进行配置
return array(

);
PC;
		//需要写入文件内容
		$writeFile = array(
			array(PROJECT.'/common/functions.php' ,       $writeContent_functions ),   
			array(APP.'/config.php' ,                     $writeContent_config    ),   
			array(APP.    '/controller/Index.class.php',  $writeContent_index     ),   
		);

		foreach($file as $k=>$v){
			if( !file_exists( $v[0] ) ){
				if(touch( $v[0] ) && is_writable($v[0]) ){
						foreach($writeFile as $key=>$val){
							//如果是要写入文件内容	
							if ( $v[0] == $val[0] ) file_put_contents($v[0], $val[1]);
						}
						echo $v[2];
				}
				
			}
		}
		unset($directory,$file,$writeContent_functions,$writeContent_config,$writeContent_index,$writeFile);
	}
}