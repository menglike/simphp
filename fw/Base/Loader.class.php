<?php
namespace Base;
class Loader{
    public static  function load_class($class)
    {
        echo '<br />加载了 '.$class.' 类&nbsp;';
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
        array_search($class,$classArr) ? require_once(ZENDFRAME.'/Base/'.array_search($class,$classArr).'.class.php') : die('对不起,找不到该'.$class.'类 :(') ;
    }

}