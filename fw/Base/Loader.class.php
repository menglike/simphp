<?php
#描述:加载所有相关的类
namespace Base;
class Loader {
    public static function load_class($class)
    {
        $classArr = array(
            'Simphp'    =>'Base\Simphp',
            'Route'     =>'Base\Route',
            'Structure' =>'Base\Structure',
            'Debug'     =>'Base\Debug',
            'Log'       =>'Base\Log',
            'Controller'=>'Base\Controller',
            'Model'     =>'Base\Model',
            'Mytpl'     =>'Base\Mytpl',
            'Db'        =>'Base\Db'
        );
        $className =  array_search($class,$classArr);
        $className ? require_once(ZENDFRAME.'/Base/'.$className.'.class.php') : die('对不起,找不到该'.$class.'类!') ;
    }

}