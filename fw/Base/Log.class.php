<?php
namespace Base;
class Log{
	public static function record($msg)
	{
		$logFile = PROJECT.'/runtime/cache/log/'.date('Y-m-d').'.log';
		is_writable(PROJECT.'/runtime/cache/log') ? touch($logFile,0777) : die(PROJECT.'/runtime/cache/log 目录不可写');	 
		file_put_contents($logFile, $msg.PHP_EOL, FILE_APPEND);
	}
}