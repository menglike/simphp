<?php
namespace Base;
use PDO;
class Model{
	public static $masterInstance;
	public static $slaveInstance;

	public static function getInstance($dbType='master')
	{
		switch($dbType){
			case 'master':
				echo "<br />go master";
		        return self::getMasterInstance();
			break;
			case 'slave':
				echo "<br />go slave";
				return self::getSlaveInstance();
			break;
		}
	}

	public static function getMasterInstance()
	{
		if( !isset( self::$masterInstance ) ){
			try{
					self::$masterInstance = new PDO('mysql:host='.DB_MASTER_HOST.';dbname='.DB_MASTER_DBNAME, DB_MASTER_USER, DB_MASTER_PASSWD); 
					self::$masterInstance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  //禁止本地转义
					self::$masterInstance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );  //
					self::$masterInstance->query('set names utf8');
			}catch(PDOException $e){
				die('连接数库失败：:'.$e->getMessage());
			}
		}
		return self::$masterInstance;
	}

	public static function getSlaveInstance()
	{
		if( !isset( self::$slaveInstance ) ){
			try{
					self::$slaveInstance = new PDO('mysql:host='.DB_SLAVE_HOST.';dbname='.DB_SLAVE_DBNAME, DB_SLAVE_USER, DB_SLAVE_PASSWD); 
					self::$slaveInstance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  //禁止本地转义
					self::$slaveInstance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION );  //
					self::$slaveInstance->query('set names utf8');
			}catch(PDOException $e){
				die('连接数库失败：:'.$e->getMessage());
			}
		}
		return self::$slaveInstance;
	}


	public  function _beginTransaction(){
		self::getMasterInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, false); //关闭自动提交
		self::getMasterInstance()->beginTransaction();
	}

	public  function _commit(){
		try{
			self::getMasterInstance()->commit();   //事务提交
		}catch(PDOException $e){
				die('连接数库操作失败：:'.$e->getMessage());
		}
		self::getMasterInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, true); //开启自动提交
	}

	public  function _rollback(){
		try{
			self::getMasterInstance()->rollback(); //事务回滚
		}catch(PDOException $e){
				die('连接数库操作失败：:'.$e->getMessage());
		}
		self::getMasterInstance()->setAttribute(PDO::ATTR_AUTOCOMMIT, true); //开启自动提交
	}
}