<?php
defined('DB_MASTER_HOST')   || define( 'DB_MASTER_HOST'         , 'localhost' );	//定义数据库主机(主数据库)	
defined('DB_MASTER_DBNAME') || define( 'DB_MASTER_DBNAME'       , 'test' );		//定义数据库名称(主数据库)	
defined('DB_MASTER_USER')   || define( 'DB_MASTER_USER'         , 'root' );		//定义数据库登录用户(主数据库)	
defined('DB_MASTER_PASSWD') || define( 'DB_MASTER_PASSWD'       , 'root' );		//定义数据库登录密码(主数据库)	
defined('DB_MASTER_PORT')   || define( 'DB_MASTER_PORT'         , '3306' );		//定义数据库端口(主数据库)	
defined('DB_SLAVE_HOST')    || define( 'DB_SLAVE_HOST'          , 'localhost' );	//定义数据库主机(从数据库1)		
defined('DB_SLAVE_NAME')    || define( 'DB_SLAVE_DBNAME'        , 'test' );		//定义数据库名称(从数据库1)
defined('DB_SLAVE_DBUSER')  || define( 'DB_SLAVE_USER'          , 'root' );		//定义数据库登录用户(从数据库1)
defined('DB_SLAVE_PASSWD')  || define( 'DB_SLAVE_PASSWD'        , 'root' );		//定义数据库登录密码(从数据库1)
defined('DB_SLAVE_PORT')    || define( 'DB_SLAVE_PORT'          , '3306' );		//定义数据库端口(从数据库1)
defined('PATH_TYPE')        || define( 'PATH_TYPE'              , 2);            //定义路由类型  1=>pathinfo 2=>普通模式
defined('TPL_EXTEND')       || define( 'TPL_EXTEND'             , 'html');       //定义模版文件的后缀名
defined('DEBUG')            || define( 'DEBUG'                  , 0 ); 			//定义调试模式,1或者true为开启,调试信息显示输出，0或者false为关闭 调试信息保存到定文件
defined('CACHESTART')       || define( 'CACHESTART'             , 1 ); 		    //设置页面是否静态化 true或者1开启 false或者0关闭
defined('CACHETIME')        || define( 'CACHETIME'              , 60*60*24);     // 页面静态化缓存时间
defined('CACHEDIR')         || define( 'CACHEDIR'               , PROJECT.'/runtime/cache/filecache/');    // 缓存目录
defined('URLDELIMITER')     || define( 'URLDELIMITER'           , '-');    // url分隔符
