<?php
/**
 * 统一入口文件
 */
//标志常量定义
define('AFA', true);

//版本号
define('VERSION', '0.1');

//调试状态, 为上线产品时请设置为 false
define('DEBUG', true);

//文件扩展名
define('EXT', '.php');

//开始时间
define('AFA_START_TIME', microtime(true));
//开始内存大小
define('AFA_START_MEMORY', memory_get_usage());

//网站根目录所在路径
define('DOCROOT', dirname(__FILE__));
//项目所在目录路径
define('PROROOT', dirname(DOCROOT));
//system 目录
define('SYSTEMPATH', PROROOT.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR);
//system class 所在目录
define('CLASSPATH', SYSTEMPATH.'class'.DIRECTORY_SEPARATOR);
//application 应用所在目录
define('APPPATH', PROROOT.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR);
//modules 模块所在目录
define('MODULEPATH', PROROOT.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR);
//controller 所在目录
define('CONPATH', APPPATH.'controller'.DIRECTORY_SEPARATOR);
//model 所在目录
define('MODPATH', APPPATH.'model'.DIRECTORY_SEPARATOR);
//view 所在目录
define('VIEPATH', APPPATH.'view'.DIRECTORY_SEPARATOR);
//diver 驱动所在目录
define('DRIVERPATH',CLASSPATH.'driver'.DIRECTORY_SEPARATOR);

require(CLASSPATH.'core'.EXT);
require(CLASSPATH.'db.php');
require(CLASSPATH.'common.php');

//声明为全局变量
global $cModule, $useModule, $modules;

//使用模型, 当访问$modules里的文件时，将自动设置为 true
$useModule = false;
//默认模型名
$cModule = false;
//默认控制器
$cController = 'hello';
//默认方法名
$cMethod	 = 'index';
//其他参数
$cParams    = array();

/**
 * 打开的模块设置
 */
$modules = array(
    'blog' => MODULEPATH.'blog'.DIRECTORY_SEPARATOR,
    'user' => MODULEPATH.'user'.DIRECTORY_SEPARATOR,
    'codemaker' => MODULEPATH.'codemaker'.DIRECTORY_SEPARATOR,//生成模块代码，正式生产环境下请删除此行

);

//载入配置文件
require 'config.php';

//执行请求
Request::instance()->run();

if (DEBUG){
    function convert($size){
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
    
    $time = microtime(true) - AFA_START_TIME;
    $memory = memory_get_usage();
    echo '<hr />';
    echo 'Time:' . round($time, 6) . ' s<br />Memory:start:' . convert(AFA_START_MEMORY).', end:'.convert($memory);
}
?>