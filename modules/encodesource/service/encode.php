<?php

/**
 * Created by PhpStorm.
 * User: ZSF
 * Date: 17/1/4
 * Time: 上午11:13
 */
class Encodesource_encode_Service
{

    /**
     *
     * PHP源码文件加密, 把需要加密的文件存放在 htmlroot/important目录下,
     * 加密完成后将生成可直接使用的文件, 新文件存放目录为 runtime/tempfile
     * 新文件名称规则为: temp_$filename
     *
     * @param $filename 文件名称, 此文件需存放在 htmlroot/important目录下
     * @param string $key  加解密key
     * @return
     */
    public static function encodeSource($filename, $key = 'afaphp.com'){

        $file = PROROOT.DIRECTORY_SEPARATOR.'htmlroot'.DIRECTORY_SEPARATOR.'important'.DIRECTORY_SEPARATOR.$filename;

        //需要加密的源代码
        //$target_source = file_get_contents($file);
        //加密得到二进制代码
        $target_source_encode = textauth::instance()->encrypt(php_strip_whitespace($file), $key);

        //二进制文件保持
        $target_source_store_path = PROROOT.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'tempfile'.DIRECTORY_SEPARATOR.'temp_'.$filename;
        file_put_contents($target_source_store_path, $target_source_encode);

        //解密类
        $tdecode_source_path = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."helper".DIRECTORY_SEPARATOR.'tdecode.php';

        //对解密类进行加密
        $target_php_source = self::encodeString(php_strip_whitespace($tdecode_source_path));

        //对目标二进制代码进行解密 语句
        $target_source_decode = '<?php '."\n".'$target_source = tdecode::instance()->decrypt(file_get_contents("'.$target_source_store_path.'"), "'.$key.'");  eval(substr($target_source, 5, strlen($target_source)-2));'. "\n".' ?>';
        $target_source_decode = self::encodeString($target_source_decode);

        $target_php_source = $target_php_source.$target_source_decode;

        $target_php_source = '<?php '."\n".$target_php_source."\n".' ?>';

        // 生成 加密后的PHP文件
        $fpp1 = fopen(PROROOT.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'tempfile'.DIRECTORY_SEPARATOR.$filename, 'w');
        fwrite($fpp1, $target_php_source) or die('写文件错误');
    }

    public static function RandAbc($length = "")
    { // 返回随机字符串
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        return str_shuffle($str);
    }

    /**
     *
     * 源代码加密-字符串混淆加密,加密后的文件可以直接include使用
     *
     * @param $phpsource  PHP源码
     * @return string  加密后的字符串, 不包含 <?php ?> 标签
     */
    public static function encodeString($phpsource)
    {
        $T_k1 = self::RandAbc(); //随机密匙1
        $T_k2 = self::RandAbc(); //随机密匙2
        $vstr = $phpsource;
        $v1 = base64_encode($vstr);
        $c = strtr($v1, $T_k1, $T_k2); //根据密匙替换对应字符。
        $c = $T_k1.$T_k2.$c;
        $q1 = "O00O0O";
        $q2 = "O0O000";
        $q3 = "O0OO00";
        $q4 = "OO0O00";
        $q5 = "OO0000";
        $q6 = "O00OO0";
        $s = '$'.$q6.'=urldecode("%6E1%7A%62%2F%6D%615%5C%76%740%6928%2D%70%78%75%71%79%2A6%6C%72%6B%64%679%5F%65%68%63%73%77%6F4%2B%6637%6A");$'.$q1.'=$'.$q6.'{3}.$'.$q6.'{6}.$'.$q6.'{33}.$'.$q6.'{30};$'.$q3.'=$'.$q6.'{33}.$'.$q6.'{10}.$'.$q6.'{24}.$'.$q6.'{10}.$'.$q6.'{24};$'.$q4.'=$'.$q3.'{0}.$'.$q6.'{18}.$'.$q6.'{3}.$'.$q3.'{0}.$'.$q3.'{1}.$'.$q6.'{24};$'.$q5.'=$'.$q6.'{7}.$'.$q6.'{13};$'.$q1.'.=$'.$q6.'{22}.$'.$q6.'{36}.$'.$q6.'{29}.$'.$q6.'{26}.$'.$q6.'{30}.$'.$q6.'{32}.$'.$q6.'{35}.$'.$q6.'{26}.$'.$q6.'{30};eval($'.$q1.'("'.base64_encode('$'.$q2.'="'.$c.'";eval(\'?>\'.$'.$q1.'($'.$q3.'($'.$q4.'($'.$q2.',$'.$q5.'*2),$'.$q4.'($'.$q2.',$'.$q5.',$'.$q5.'),$'.$q4.'($'.$q2.',0,$'.$q5.'))));').'"));';
        return $s;
    }

}