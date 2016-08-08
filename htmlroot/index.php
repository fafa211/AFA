<?php
/**
 * 统一入口文件
 */
//标志常量定义
define('AFA', true);

//版本号
define('VERSION', '1.0');

//调试状态, 0 不输出调试信息, 1输出到页面, 2输出到文件
define('DEBUG', 2);

//打开代码提示
ini_set('display_errors', 'on');

//文件扩展名
define('EXT', '.php');

define('CHARSET', 'utf8');

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
//diver 驱动所在目录
define('DRIVERPATH',CLASSPATH.'driver'.DIRECTORY_SEPARATOR);

require(CLASSPATH.'core'.EXT);
require(CLASSPATH.'db.php');
require(CLASSPATH.'F.php');

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
    'codemaker' => MODULEPATH.'codemaker'.DIRECTORY_SEPARATOR,//生成模块代码，正式生产环境下请删除此行
    //'blog' => MODULEPATH.'blog'.DIRECTORY_SEPARATOR,
    //'user' => MODULEPATH.'user'.DIRECTORY_SEPARATOR,
    'idcarea' => MODULEPATH.'idcarea'.DIRECTORY_SEPARATOR,
    'iparea' => MODULEPATH.'iparea'.DIRECTORY_SEPARATOR,
    'man' => MODULEPATH.'man'.DIRECTORY_SEPARATOR,
    'phonearea' => MODULEPATH.'man'.DIRECTORY_SEPARATOR,


);

//载入配置文件
require 'config.php';

//执行请求
$request = Request::instance()->run();

//输出性能调试信息
F::debug($request);

?>