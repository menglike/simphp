<?php
namespace Base;
use PDO;
class Model{
	private static $instance;
	public static function getInstance()
	{
		if( !isset( self::$instance ) ){
			try{
				self::$instance = new PDO('mysql:host=;dbname=', '', '');
				self::$instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  //禁止本地转义
				self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );  //
				self::$instance->query('set names utf8');
			}catch(PDOException $e){
				die('连接数库失败：:'.$e->getMessage());
			}
		}
		return self::$instance;
	}

	public  function _beginTransaction(){    //开启事务
		self::getInstance()->beginTransaction();
	}

	public  function _commit(){
			self::getInstance()->commit();   //事务提交
	}

	public  function _rollback(){
			self::getInstance()->rollback(); //事务回滚
	}
}