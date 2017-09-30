<?php
namespace Base;
use PDO;
class Model{
	public static $instance;

	public static function getInstance()
	{
		if( !isset( self::$instance ) ){
			try{
				self::$instance = new PDO('mysql:host=121.199.58.207;dbname=wx_activity', 'wx_imooc', 'c641q512!@#'); 
				self::$instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  //禁止本地转义
				self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );  //
				self::$instance->query('set names utf8');
			}catch(PDOException $e){
				die('连接数库失败：:'.$e->getMessage());
			}
		}
		return self::$instance;
	}


	public  function _beginTransaction(){
		self::getInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, false); //关闭自动提交
		self::getInstance()->beginTransaction();
	}

	public  function _commit(){
		try{
			self::getInstance()->commit();   //事务提交
		}catch(PDOException $e){
				die('连接数库操作失败：:'.$e->getMessage());
		}
		self::getInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, true); //开启自动提交
	}

	public  function _rollback(){
		try{
			self::getInstance()->rollback(); //事务回滚
		}catch(PDOException $e){
				die('连接数库操作失败：:'.$e->getMessage());
		}
		self::getInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, true); //开启自动提交
	}
}