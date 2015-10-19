<?php
/**
 * 统一入口文件
 */
echo microtime().'<br />';
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

/**
 * 当前控制器与方法
 */
if (isset($_SERVER['PATH_INFO'])) {
    //从网址访问时使用
    $path_vars = explode('/', $_SERVER['PATH_INFO']);
}elseif (isset($_SERVER['argc']) && $_SERVER['argc']>1){
    //从命令行访问时使用，获取命令行参数
    $first_word = substr($_SERVER['argv'][1], 0, 1);
    if ($first_word != '/') {
        $_SERVER['argv'][1] = '/'.$_SERVER['argv'][1];
    }
    $afa_vars = explode('?', $_SERVER['argv'][1]);
    $path_vars = explode('/', $afa_vars[0]);
    if (isset($afa_vars[1])){
        $afa_vars = explode('&', $afa_vars[1]);
        foreach ($afa_vars as $afa_str){
            $arr = explode('=', $afa_str);
            //初始化get的值
            $_GET[$arr[0]] = @$arr[1];
        }
    }
}
if(isset($path_vars[1]))  $cModule = $path_vars[1];//模型名

/**
 * 控制器物理文件
 */
if(isset($modules[$cModule])){
    $cFile = $modules[$cModule].'controller'.DIRECTORY_SEPARATOR.$cModule.EXT;
    if (file_exists($cFile)){
        include($cFile);
        $cController = $cModule;
        if(isset($path_vars[2]))  $cMethod = $path_vars[2];//方法名
        if (isset($path_vars[3])) $cParams = array_slice($path_vars, 3);//参数
    }else{
        if(isset($path_vars[2]))  $cController = $path_vars[2];//方法名
        $cFile = $modules[$cModule].'controller'.DIRECTORY_SEPARATOR.$cController.EXT;
        if (file_exists($cFile)) {
            include($cFile);
            if (isset($path_vars[3])) $cMethod = $path_vars[3];//参数
            if (isset($path_vars[4])) $cParams = array_slice($path_vars, 4);//参数
        }else{
            common::go404("控制器 {$cController}不存在!".$cFile);
        }
    }
    $useModule = true;
}else {
    $cController = $cModule;
    $cFile = CONPATH.$cController.EXT;
    if (file_exists($cFile)) {
        include($cFile);
        if(isset($path_vars[2]))  $cMethod = $path_vars[2];//方法名
        if (isset($path_vars[3])) $cParams = array_slice($path_vars, 3);//参数
    }else{
        common::go404("控制器 {$cController} 不存在!");
    }
}


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

echo microtime().'<br />';

?>