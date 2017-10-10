<?php
namespace Base;
use PDO;
class Db extends Model{

	public static function dealSql($type,$sql,$values=array(),$dbType='master')
	{
		try{
			Debug::addMsg('执行了sql:'.$sql);
			$st = parent::getInstance($dbType)->prepare($sql);
			$st->execute($values);
			switch($type){
				case 'select':
				return $st->fetchAll(PDO::FETCH_ASSOC);
				break;
				case 'insert':
				return parent::getInstance($dbType)->lastInsertId();
				break;
				case 'update':
				return $st->rowCount();
				break;
			}
		}catch(PDOException $e){
			return $e->getMessage();
		}	
	}

}	