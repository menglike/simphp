<?php
  // 框架入口文件
  header( 'content-type:text/html;charset=utf-8' );
  // 定义项目名称
  if( !defined('APP_NAME') )                      die('必须设置APP_NAME常量!');
  if(version_compare(PHP_VERSION,'5.3.0') < 0 )   die('php版本必须>=5.3.0!');
  // 设置默认时区
  date_default_timezone_set("Asia/Shanghai");         //设置时区（亚洲/上海）
  // 定义框架目录
  define( 'ZENDFRAME' , str_replace( '\\', '/', __DIR__ ) );
  // 定义项目目录  xxx为项目根目录   yyy为应用目录，由用户自定义
  define( 'PROJECT' ,  dirname( ZENDFRAME )             ); //D:/wamp/www/xxx     /usr/local/apache2/httpd/xxx
  #APP_NAME 由用户输入
  define( 'APP'     ,  PROJECT.'/'.trim( APP_NAME ,'/') ); //D:/wamp/www/xxx/yyy /usr/local/apache2/httpd/xxx/yyy

  // 加载框架的公共函数
  require ZENDFRAME.'/Common/functions.php';
  require ZENDFRAME.'/Base/Loader.class.php';   //引入自动加载类文件的文件
  spl_autoload_register('\Base\Loader::load_class');
  \Base\Simphp::run(); //运行应用

  


