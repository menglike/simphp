<?php
defined('DB_HOST')         || define( 'DB_HOST'         , 'localhost' );	//定义数据库主机	
defined('DB_NAME')         || define( 'DB_NAME'         , 'test' );		//定义数据库名称
defined('DB_USER')         || define( 'DB_USER'         , 'root' );		//定义数据库登录用户
defined('DB_PASSWD')       || define( 'DB_PASSWD'       , 'root' );		    //定义数据库登录密码
defined('DB_PORT')         || define( 'DB_PORT'         , '3306' );		//定义数据库端口
defined('PATH_TYPE')       || define( 'PATH_TYPE'       , 2);            //定义路由类型  1=>pathinfo 2=>普通模式
defined('TEMPLATE_EXTEND') || define( 'TEMPLATE_EXTEND' , 'html'); //定义模版文件的后缀名
defined('DEBUG')           || define( 'DEBUG'           , 0 ); 				//定义调试模式,1或者true为开启,调试信息显示输出，0或者false为关闭 调试信息保存到定文件
defined('CACHESTART')      || define( 'CACHESTART'      , 0 ); 		    //设置页面是否静态化 true或者1开启 false或者0关闭
defined('CACHETIME')       || define( 'CACHETIME'       , 60*60*24);    // 页面静态化缓存时间
defined('CACHEDIR')        || define( 'CACHEDIR'        , PROJECT.'/runtime/cache/filecache/');    // 缓存目录
