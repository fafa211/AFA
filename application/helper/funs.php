<?php

/**
 * Created by PhpStorm.  常用静态方法库
 * User: ZSF
 * Date: 16/7/27
 * Time: 下午4:07
 */
class funs
{
    /**
     * 验证身份证号
     * @param $vStr
     * @return bool
     */
    public static function isCreditNo($vStr)
    {
        $vCity = array(
            '11','12','13','14','15','21','22',
            '23','31','32','33','34','35','36',
            '37','41','42','43','44','45','46',
            '50','51','52','53','54','61','62',
            '63','64','65','71','81','82','91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

        if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);

        if ($vLength == 18)
        {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }

        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
        if ($vLength == 18)
        {
            $vSum = 0;

            for ($i = 17 ; $i >= 0 ; $i--)
            {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
            }

            if($vSum % 11 != 1) return false;
        }

        return true;
    }

    /**
     *
     * 解析JS对象字符串
     * @param $str
     * @param $return 返回结果类型
     * @return array|object|空字符串
     */
    public static function parseJsObjectString($str = '', $return = 'array'){

        $str = trim($str);
        if(empty($str)) return '';

        $str = substr($str, stripos($str, '{')+1);
        if(substr($str, -1) == '}') {
            $str = substr($str, 0, -1);
        }
        $strArr = explode(',', $str);

        $ret = array();
        foreach($strArr as $s){
            list($k, $v) = explode(':', $s);
            $ret[trim($k)] = str_replace(array('\'','"'),'',trim($v));
        }

        return $return == 'array'?$ret:(object)$ret;
    }

}