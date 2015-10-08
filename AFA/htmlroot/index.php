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

//默认控制器
$cController = 'hello';
//默认方法名
$cMethod	 = 'index';
//其他参数
$cParams    = array();

//载入配置文件
require 'config.php';

/**
 * 当前控制器与方法
 */
if (isset($_SERVER['PATH_INFO'])) {
    //从网址访问时使用
    $vars = explode('/', $_SERVER['PATH_INFO']);
    if(isset($vars[1]))  $cController = $vars[1];
    if(isset($vars[2]))  $cMethod = $vars[2];
    if (isset($vars[3])) $cParams = array_slice($vars, 3);
}elseif (isset($_SERVER['argc']) && $_SERVER['argc']>1){
    //从命令行访问时使用，获取命令行参数
    $afa_vars = explode('?', $_SERVER['argv'][1]);
    $vars = explode('/', $afa_vars[0]);
    $cController = $vars[0];
    if(isset($vars[1]))  $cMethod = $vars[1];
    if (isset($vars[2])) $cParams = array_slice($vars, 2);
    if (isset($afa_vars[1])){
        $afa_vars = explode('&', $afa_vars[1]);
        foreach ($afa_vars as $afa_str){
            $arr = explode('=', $afa_str);
            $_GET[$arr[0]] = @$arr[1];
        }
    }
}

/**
 * 控制器物理文件
 */
$cFile = CONPATH.$cController.EXT;
file_exists($cFile) && include($cFile);

try {
	//controller 类的命名规则为：文件名(首字母大写)+'_Controller'
	$class = new ReflectionClass(ucfirst($cController).'_Controller');
}catch (ReflectionException $e){
	common::go404($e->getMessage());
}

// Create a new controller instance
$controller = $class->newInstance();
try{
	// Load the controller method
	$method = $class->getMethod($cMethod);
	if ($method->isProtected() or $method->isPrivate()){
		common::go404('protected controller method');
	}
} catch (ReflectionException $e){
	// Use __call instead
	$method = $class->getMethod('__call');

	// Use arguments in __call format
	array_unshift($cParams, $cMethod);
}

// Execute the controller method
$method->invokeArgs($controller, $cParams);

?>