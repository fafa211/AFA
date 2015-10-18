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
}