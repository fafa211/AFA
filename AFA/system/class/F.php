<?php

/**
 * 系统常用静态方法
 * @author zhengshufa
 *
 */
class F{
    
    /**
     * 从数组中查找需要的数据
     * @param string|int $needle
     * @param array $arr
     * @return string: for show string
     */
    public static function findInArray($needle, $arr){
        if (isset($arr[$needle])) return $arr[$needle];
        if (strpos($needle, ',') !== FALSE){
            $needle_arr = explode(',', $needle);
            
            $rs = array();
            foreach ($needle_arr as $v){
                if (isset($arr[$v])) array_push($rs, $arr[$v]);
            }
            if (!empty($rs)) return join(',', $rs);
        }
        return $needle;
    }
    
    /**
     * 手动载入module文件方法
     * @param string $module: module名称
     * @param string $class_name 类名称
     */
    public static function load($module, $class_name){
        global $modules;
        if (!isset($modules[$module])) return false;
        
        if (strpos($class_name, '_') === false){
            $file = MODULEPATH.$module.DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR.$class_name.EXT;
            if (file_exists($file))	return include($file);
        }else{
            $lastpos = strrpos($class_name, '_');
            $suffix = substr($class_name, $lastpos+1);
            $file = '';
            $class_name = substr($class_name, 0, $lastpos);
            if ($suffix == 'Model'){
                $file = MODULEPATH.$module.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.strtolower($class_name).EXT;
            }elseif ($suffix == 'Controller'){
                $file = MODULEPATH.$module.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.strtolower($class_name).EXT;
            }
            if ($file && file_exists($file)) return include($file);
        }
        return false;
    }
    
    /**
     * 创建对象，调用其他模型类，并生成对象
     * @param string $module: module名称
     * @param string $class_name 类名称
     * @param string|in|array 类构造函数的参数
     * @return object 返回一个对象
     */
    public static function object($module, $class_name, $args){
        $rs = self::load($module, $class_name);
        if($rs === false) exit("Load $class_name failure!");
        $class = new ReflectionClass($class_name);
        return $class->newInstance($args);
    }
}