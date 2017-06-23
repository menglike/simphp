<?php
namespace Base;
use PDO;
class Db extends Model{
	public static function dealSql($type,$sql,$values)
	{
		try{
			Debug::addMsg('执行了sql:'.$sql);
			$st = parent::getInstance()->prepare($sql);
			$st->execute($values);
			switch($type){
				case 'select':
					return $st->fetchAll(PDO::FETCH_ASSOC);
					break;
				case 'selectOne':
					return $st->fetch(PDO::FETCH_ASSOC);
					break;
				case 'insert':
					return parent::getInstance()->lastInsertId();
					break;
				case 'update':
					return $st->rowCount();
					break;
			}
		}catch(PDOException $e){
			die( $e->getMessage() );
		}	
	}

}	