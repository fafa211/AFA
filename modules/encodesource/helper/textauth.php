<?php
/**
 * 把字符串文本加密成二进制字符串
 * 把二进制字符串解密成普通字符串文本
 *
 * User: ZSF
 * Date: 16/12/29
 * Time: 下午5:50
 */

class textauth
{
    private $n_iter;

    static function instance(){
        return new textauth();
    }

    public function __construct()
    {
        $this->setIter(32);
    }

    public function setIter($n_iter)
    {
        $this->n_iter = $n_iter;
    }

    public function getIter()
    {
        return $this->n_iter;
    }

    /**
     * @param $data 需要加密的字符串
     * @param $key  密钥
     * @return string 加密后的二进制字符串
     */
    public function encrypt($data, $key)
    {
        $n = $this->_resize($data, 4);

        $data_long[0] = $n;
        $n_data_long = $this->_str2long(1, $data, $data_long);

        $n = count($data_long);
        if (($n & 1) == 1) {
            $data_long[$n] = chr(0);
            $n_data_long++;
        }

        $this->_resize($key, 16, true);
        if ( '' == $key )
            $key = '0000000000000000';

        $n_key_long = $this->_str2long(0, $key, $key_long);

        $enc_data = '';
        $w = array(0, 0);
        $j = 0;
        $k = array(0, 0, 0, 0);
        for ($i = 0; $i < $n_data_long; ++$i) {
            if ($j + 4 <= $n_key_long) {
                $k[0] = $key_long[$j];
                $k[1] = $key_long[$j + 1];
                $k[2] = $key_long[$j + 2];
                $k[3] = $key_long[$j + 3];
            } else {
                $k[0] = $key_long[$j % $n_key_long];
                $k[1] = $key_long[($j + 1) % $n_key_long];
                $k[2] = $key_long[($j + 2) % $n_key_long];
                $k[3] = $key_long[($j + 3) % $n_key_long];
            }
            $j = ($j + 4) % $n_key_long;

            $this->_encipherLong($data_long[$i], $data_long[++$i], $w, $k);

            $enc_data .= $this->_long2str($w[0]);
            $enc_data .= $this->_long2str($w[1]);
        }

        return $enc_data;
    }

    /**
     * @param $data 需要解密的字符串
     * @param $key  密钥
     * @return string 解密后的二进制字符串
     */
    public function decrypt($enc_data, $key)
    {
        $n_enc_data_long = $this->_str2long(0, $enc_data, $enc_data_long);

        $this->_resize($key, 16, true);
        if ( '' == $key ) {
            $key = '0000000000000000';
        }

        $n_key_long = $this->_str2long(0, $key, $key_long);

        $data = '';
        $w = array(0, 0);
        $j = 0;
        $len = 0;
        $k = array(0, 0, 0, 0);
        $pos = 0;

        for ($i = 0; $i < $n_enc_data_long; $i += 2) {
            if ($j + 4 <= $n_key_long) {
                $k[0] = $key_long[$j];
                $k[1] = $key_long[$j + 1];
                $k[2] = $key_long[$j + 2];
                $k[3] = $key_long[$j + 3];
            } else {
                $k[0] = $key_long[$j % $n_key_long];
                $k[1] = $key_long[($j + 1) % $n_key_long];
                $k[2] = $key_long[($j + 2) % $n_key_long];
                $k[3] = $key_long[($j + 3) % $n_key_long];
            }
            $j = ($j + 4) % $n_key_long;

            $this->_decipherLong($enc_data_long[$i], $enc_data_long[$i + 1], $w, $k);

            if (0 == $i) {
                $len = $w[0];
                if (4 <= $len) {
                    $data .= $this->_long2str($w[1]);
                } else {
                    $data .= substr($this->_long2str($w[1]), 0, $len % 4);
                }
            } else {
                $pos = ($i - 1) * 4;
                if ($pos + 4 <= $len) {
                    $data .= $this->_long2str($w[0]);

                    if ($pos + 8 <= $len) {
                        $data .= $this->_long2str($w[1]);
                    } elseif ($pos + 4 < $len) {
                        $data .= substr($this->_long2str($w[1]), 0, $len % 4);
                    }
                } else {
                    $data .= substr($this->_long2str($w[0]), 0, $len % 4);
                }
            }
        }
        return $data;
    }

    private function _encipherLong($y, $z, &$w, &$k)
    {
        $sum = (integer) 0;
        $delta = 0x9E3779B9;
        $n = (integer) $this->n_iter;

        while ($n-- > 0) {
            $y = $this->_add($y,
                $this->_add($z << 4 ^ $this->_rshift($z, 5), $z) ^
                $this->_add($sum, $k[$sum & 3]));
            $sum = $this->_add($sum, $delta);
            $z = $this->_add($z,
                $this->_add($y << 4 ^ $this->_rshift($y, 5), $y) ^
                $this->_add($sum, $k[$this->_rshift($sum, 11) & 3]));
        }

        $w[0] = $y;
        $w[1] = $z;
    }

    private function _decipherLong($y, $z, &$w, &$k)
    {
        $sum = 0xC6EF3720;
        $delta = 0x9E3779B9;
        $n = (integer) $this->n_iter;

        while ($n-- > 0) {
            $z = $this->_add($z,
                -($this->_add($y << 4 ^ $this->_rshift($y, 5), $y) ^
                    $this->_add($sum, $k[$this->_rshift($sum, 11) & 3])));
            $sum = $this->_add($sum, -$delta);
            $y = $this->_add($y,
                -($this->_add($z << 4 ^ $this->_rshift($z, 5), $z) ^
                    $this->_add($sum, $k[$sum & 3])));
        }

        $w[0] = $y;
        $w[1] = $z;
    }

    private function _resize(&$data, $size, $nonull = false)
    {
        $n = strlen($data);
        $nmod = $n % $size;
        if ( 0 == $nmod )
            $nmod = $size;

        if ($nmod > 0) {
            if ($nonull) {
                for ($i = $n; $i < $n - $nmod + $size; ++$i) {
                    $data[$i] = $data[$i % $n];
                }
            } else {
                for ($i = $n; $i < $n - $nmod + $size; ++$i) {
                    $data[$i] = chr(0);
                }
            }
        }
        return $n;
    }

    private function _hex2bin($str)
    {
        $len = strlen($str);
        return pack('H' . $len, $str);
    }

    private function _str2long($start, &$data, &$data_long)
    {
        $n = strlen($data);

        $tmp = unpack('N*', $data);
        $j = $start;

        foreach ($tmp as $value)
            $data_long[$j++] = $value;

        return $j;
    }

    private function _long2str($l)
    {
        return pack('N', $l);
    }

    private function _rshift($integer, $n)
    {
        if (0xffffffff < $integer || -0xffffffff > $integer) {
            $integer = fmod($integer, 0xffffffff + 1);
        }

        if (0x7fffffff < $integer) {
            $integer -= 0xffffffff + 1.0;
        } elseif (-0x80000000 > $integer) {
            $integer += 0xffffffff + 1.0;
        }

        if (0 > $integer) {
            $integer &= 0x7fffffff;
            $integer >>= $n;
            $integer |= 1 << (31 - $n);
        } else {
            $integer >>= $n;
        }

        return $integer;
    }

    private function _add($i1, $i2)
    {
        $result = 0.0;

        foreach (func_get_args() as $value) {
            if (0.0 > $value) {
                $value -= 1.0 + 0xffffffff;
            }

            $result += $value;
        }

        if (0xffffffff < $result || -0xffffffff > $result) {
            $result = fmod($result, 0xffffffff + 1);
        }

        if (0x7fffffff < $result) {
            $result -= 0xffffffff + 1.0;
        } elseif (-0x80000000 > $result) {
            $result += 0xffffffff + 1.0;
        }
        return $result;
    }
}
?>