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
    
    /**
     * 读取配置
     */
    public static function config($str)
    {
        list($main, $sub) = explode('.', $str);
        if (isset($GLOBALS['config'][$main]) && isset($GLOBALS['config'][$main][$sub])) return $GLOBALS['config'][$main][$sub];
        if (isset($GLOBALS['config'][$main])) return $GLOBALS['config'][$main];
        return $GLOBALS['config'];
    }
    
    /**
     * 获取客户端IP
     */
    public static function getIp() {
        $ip = $_SERVER['REMOTE_ADDR'];
        if( isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches) ) {
            foreach ($matches[0] as $value_ip) {
                if (!preg_match('/^(10|172\.16|192\.168)\./', $value_ip)) {
                    $ip = $value_ip;
                    break;
                }
            }
        }
        return $ip;
    }
    
    /**
     * 字符串加密、解密函数
     *
     * @param    string    $string        字符串
     * @param    string    $operation    ENCODE为加密，DECODE为解密，可选参数，默认为DECODE，
     * @param    string    $key        密钥：数字、字母、下划线
     * @param    string    $expiry        过期时间
     * @return    string
     */
    public static function authstr($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $key_length = 5; // 随机密钥长度 取值 0-32
        $key = md5( $key != '' ? $key : self::config('authkey'));
        $fixedkey = md5($key);
        $egiskeys = md5(substr($fixedkey, 16, 16));
        $runtokey = $key_length ? ($operation == 'DECODE' ? substr($string, 0, $key_length) : substr(md5(microtime(true)), -$key_length)) : '';
        $keys = md5(substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
        $string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));
    
        $i = 0;
        $result = '';
        $string_length = strlen($string);
        for ($i = 0; $i < $string_length; $i++) {
            $result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
        }
        if($operation == 'ENCODE') {
            return $runtokey . str_replace('=', '', base64_encode($result));
        } else {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$egiskeys), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        }
    }
    
    /**
     * 字符串截取，支持中文和其他编码
     * @param string $str
     * @param int $start
     * @param int $length
     * @param string $charset
     * @param boolean $suffix
     * @return string
     */
    static function substr($str, $start = 0, $length, $charset = "utf-8", $suffix = TRUE) {
        $suffix_str = $suffix ? '…' : '';
        if(function_exists('mb_substr')) {
            return mb_substr($str, $start, $length, $charset) . $suffix_str;
        } elseif(function_exists('iconv_substr')) {
            return iconv_substr($str, $start, $length, $charset) . $suffix_str;
        } else {
            $pattern = array();
            $pattern['utf-8'] = '/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/';
            $pattern['gb2312'] = '/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/';
            $pattern['gbk'] = '/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/';
            $pattern['big5'] = '/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/';
            preg_match_all($pattern[$charset], $str, $matches);
            $slice = implode("", array_slice($matches[0], $start, $length));
            return $slice . $suffix_str;
        }
    }
    
    /**
     * 信息提示
     * @param string $message
     * @param string $url
     * @param number $refresh
     * @param boolean $exit
     */
    static function tip($message, $url = '', $refresh = 3, $exit = false){
        header("HTTP/1.1 200 OK");
        header("Status: 200");
        header("Content-Type: text/html; charset=UTF-8");
        if ($url){
            header("refresh:$refresh;url=$url");
        }
        if (preg_match('/MSIE/i', input::server('HTTP_USER_AGENT'))) {
            echo str_repeat(" ", 512);
        }
        echo $message;
        if ($exit) exit();
    }
}