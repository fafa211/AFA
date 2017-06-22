<?php

/**
 * Created by PhpStorm.
 * User: ZSF
 * Date: 16/8/24
 * Time: 下午5:35
 */
class FileServer_Controller extends Server_Controller{

    //需要使用token授权的方法
    protected $use_token = array('upload','uploadPic','download', 'showImage');

    /**
     * 上传文件服务
     *
     * 使用POST提交文件,需要提供以下参数
     * name  上传文件里的  $_FILES 里相应文件的的 name属性
     * type  上传文件里的  $_FILES 里相应文件的的 type属性
     * file  上传文件里的  $_FILES 里相应文件的的 tmp_name属性
     *
     * 例子: 比如上传的某个文件的属性如下
     *
     * Array
     * (
     * [name] => 微信＋销售通道.png
     * [type] => image/png
     * [tmp_name] => /private/var/tmp/phpz2nNKg
     * [error] => 0
     * [size] => 1794128
     * )
     *
     * name 的值对应为 微信＋销售通道.png
     * type 的值对应为 image/png
     * file 的值对应为 AT/private/var/tmp/phpz2nNKg
     * 注意:file 值前面一定要有AT符号,用来识别其是一个POST文件,使用CRUL POST进行提交
     *
     * @param boolean $encrypt :0或1
     * 0 为不加密, 默认为0, 为0时将会直接返回可访问的文件地址;
     * 1为加密, 不会返回可访问地址,需要经过授权, 通过指定接口才能访问;
     *
     * @return json 图片url
     * {
     *  "errNum":0, //成功标识, 0 为成功
     *  "errMsg":"success",
     *  "retData":"http://api.service.com/upload/20160825/sc_57beac8f9bf69.png" //图片地址
     * }
     *
     */
    public function upload_Action($encrypt = 0){
        //支持JS跨域上传文件,IE10以下浏览器不支持
        header('Access-Control-Allow-Origin：* ');

        $file = input::file('file');

        if($file['error'] !== 0){
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = "文件上传失败";
            $this->ret['retData'] = $file;

            return $this->echojson($this->ret);
        }

        if(input::post('name') && input::post('type')) {
            $file['name'] = input::post('name');
            $file['type'] = input::post('type');
        }

        $fileinfoArr = Upload::saveHash($file);

        if(false === $fileinfoArr){
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = "文件上传失败";

            return $this->echojson($this->ret);
        }

        //文件信息保存入库
        $fileinfo = new fileinfo_Model();
        $fileinfo->account_id   = $this->account_id;
        $fileinfo->file_name    = $file['name'];
        $fileinfo->file_type    = $file['type'];
        $fileinfo->file_size    = $file['size'];
        $fileinfo->add_time     = time();

        //加密时需要对返回的hash_id进行一次再加密
        if($encrypt == 1) {
            $fileinfo->hash_id = F::authstr($fileinfoArr['hash_id'], 'ENCODE');
        }else{
            $fileinfo->hash_id = $fileinfoArr['hash_id'];
        }

        $fileinfo->suffix       = $fileinfoArr['suffix'];
        $fileinfo->is_encrpt    = $encrypt == 1? true: false;

        $fileinfo->save();

        //$encrypt 为1时不返回文件地址, 否则返回地址
        $this->ret['retData'] = array('id'=>$fileinfo->hash_id, 'name'=>$fileinfo->file_name, 'size'=>$fileinfo->file_size);
        if($encrypt == 1){
            $this->ret['retData']['url'] = '';
        }else{
            $return_url = str_replace(DOCROOT.DIRECTORY_SEPARATOR, F::config('domain'), $fileinfoArr['filename']);
            $this->ret['retData']['url'] = $return_url;
        }

        return $this->echojson($this->ret);

    }

    /**
     * 上传图片服务
     *
     * 使用POST提交文件,需要提供以下参数
     * name  上传文件里的  $_FILES 里相应文件的的 name属性
     * type  上传文件里的  $_FILES 里相应文件的的 type属性
     * file  上传文件里的  $_FILES 里相应文件的的 tmp_name属性
     * size  array 图片裁剪尺寸, 如果不进行任何缩放则可以不传, 详细说明如下
     * 单张图片：$arr = array('w'=>120, 'h'=>90); 或 $arr = array(array(120,90); 或 array(120,90);
     * 大小图片，即两张图片：$arr = array(array(400,300),array(120,90)); array(400,300)为大图宽高，array(120,90)为小图宽高
     * 大中小图，即三张图片：$arr = array(array(1200,900),array(400,300),array(120,90)); 依次为大中小图的尺寸大小
     *
     * 例子: 比如上传的某个文件的属性如下
     *
     * Array
     * (
     * [name] => 微信＋销售通道.png
     * [type] => image/png
     * [tmp_name] => /private/var/tmp/phpz2nNKg
     * [error] => 0
     * [size] => 1794128
     * )
     *
     * name 的值对应为 微信＋销售通道.png
     * type 的值对应为 image/png
     * file 的值对应为 AT/private/var/tmp/phpz2nNKg
     * 注意:file 值前面一定要有AT符号,用来识别其是一个POST文件,使用CRUL POST进行提交
     *
     * @param boolean $encrypt :0或1
     * 0 为不加密, 默认为0, 为0时将会直接返回可访问的文件地址;
     * 1为加密, 不会返回可访问地址,需要经过授权, 通过指定接口才能访问;
     *
     * @return json 图片url
     * {
     *  "errNum":0,  //成功标识, 0 为成功
     *  "errMsg":"success",
     *  "retData":{
     *      "id":"b3645619a2951db9a72bd5ea7d25b584",
     *      "name":"组织架构问题构建.png",
     *      "size":398530,"suffix":"png",
     *      "url":"http://api.service.com/upload/b3/64/b3645619a2951db9a72bd5ea7d25b584_s.png"
     *  }
     * }
     *
     */
    public function uploadPic_Action($encrypt = 0){

        ini_set ('memory_limit', '256M');

        $file = input::file('file');

        if($file['error'] !== 0){
            $this->ret['errNum'] = $file['error'];
            $this->ret['success'] = "文件上传失败";
            $this->ret['retData'] = input::file();

            return $this->echojson($this->ret);
        }

        if(input::post('name') && input::post('type')) {
            $file['name'] = input::post('name');
            $file['type'] = input::post('type');
        }

        $size_arr = input::post('size')?json_decode(input::post('size'), true):array();

        $fileinfoArr = Upload::saveHash($file);

        if(is_array($fileinfoArr)) {
            $return_arr = $this->imageScaling($fileinfoArr['filename'], $size_arr);
            if (is_array($return_arr)) {
                $last_point = strrpos($return_arr['url'], '/');

                //图片文件信息保存入库
                $fileinfo = new fileinfo_Model();
                $fileinfo->account_id = $this->account_id;
                $fileinfo->file_name = $file['name'];
                $fileinfo->file_type = $file['type'];
                $fileinfo->file_size = $file['size'];
                $fileinfo->add_time = time();

                //加密时需要对返回的hash_id进行一次再加密
                if($encrypt == 1) {
                    $fileinfo->hash_id = F::authstr($fileinfoArr['hash_id'], 'ENCODE');
                }else{
                    $fileinfo->hash_id = $fileinfoArr['hash_id'];
                }

                $fileinfo->suffix = $fileinfoArr['suffix'];
                $fileinfo->is_encrpt    = $encrypt == 1? true: false;

                $fileinfo->extend_text = json_encode(array('type' => 'image', 'count' => $return_arr['count'], 'hash_url' => substr($return_arr['url'], $last_point + 1)));

                $fileinfo->save();

                $this->ret['retData'] = array(
                    'id' => $fileinfo->hash_id,
                    'name' => $fileinfo->file_name,
                    'size' => $fileinfo->file_size,
                    'suffix' => $fileinfo->suffix,
                    'url' => $return_arr['url']
                );
                //$encrypt 为1时不返回文件地址, 否则返回地址
                $this->ret['retData']['url'] = $encrypt == 1?'':$return_arr['url'];

                return $this->echojson($this->ret);
            }
        }

        $this->ret['errNum'] = 1;
        $this->ret['errMsg'] = "文件上传失败";

        return $this->echojson($this->ret);


    }

    /**
     * 下载文件
     *
     * get 传值, token为回话授权token, 有效期300s
     *
     * @param string $hash_id 文件唯一标识
     * @return 文件内容
     */
    public function download_Action($hash_id = ''){

        //token正常且在有效时间内, 有效时间为300秒
        if($this->token && time()-$this->token_time <= 300){
            $fileinfo = new fileinfo_Model();
            $fileinfo->getByHashId($hash_id);
            if($fileinfo->id && $this->account_id == $fileinfo->account_id ){
                $real_hash_id = F::authstr($hash_id, 'DECODE');

                // 组装文件路径
                $directory = Upload::getDirectory($real_hash_id);

                //真实文件路径
                $file_path = $directory.DIRECTORY_SEPARATOR.$real_hash_id.'.'.$fileinfo->suffix;

                if(file_exists($file_path)){
                    //存在--打开文件
                    $fp = fopen($file_path, "r");

                    //http 下载需要的响应头
                    header("Content-type: application/octet-stream"); //返回的文件
                    header("Accept-Ranges: bytes");   //按照字节大小返回
                    header("Accept-Length: " . $fileinfo->file_size); //返回文件大小
                    header("Content-Disposition: attachment; filename=" . $fileinfo->file_name);//这里客户端的弹出对话框，对应的文件名
                    //向客户端返回数据
                    //设置大小输出
                    $buffer = 1024;
                    //为了下载安全，我们最好做一个文件字节读取计数器
                    $file_count = 0;
                    //判断文件指针是否到了文件结束的位置(读取文件是否结束)
                    while (!feof($fp) && ($fileinfo->file_size - $file_count) > 0) {
                        $file_data = fread($fp, $buffer);
                        //统计读取多少个字节数
                        $file_count += $buffer;
                        //把部分数据返回给浏览器
                        echo $file_data;
                    }
                    //关闭文件
                    fclose($fp);

                    $this->ret['retData'] = 'file binary content';
                    return true;
                }
            }
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = "file not exist!";
            return $this->echojson($this->ret);
        }else{
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = "token is invalid!";
            return $this->echojson($this->ret);
        }

    }

    /**
     * 显示图片
     *
     * get 传值, token为回话授权token, 有效期300s
     *
     * @param string $hash_id 文件唯一标识
     * @param string $flag:当访问图片时才有用, s为小图, b为大图, m为中图
     * @return 文件内容
     */
    public function showImage_Action($hash_id = '', $flag = ''){

        //token正常且在有效时间内, 有效时间为300秒
        if($this->token && time()-$this->token_time <= 300){
            $fileinfo = new fileinfo_Model();
            $fileinfo->getByHashId($hash_id);
            if($fileinfo->id  && $this->account_id == $fileinfo->account_id){
                $real_hash_id = F::authstr($hash_id, 'DECODE');

                // 组装文件路径
                $directory = Upload::getDirectory($real_hash_id);

                //判断图片格式
                if (in_array($fileinfo->suffix, array('png', 'jpg', 'gif'))) {
                    if($fileinfo->extend_text) {
                        $extend_arr = json_decode($fileinfo->extend_text, true);
                        if ($extend_arr['count'] == 1) {
                            $file_path = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '.' . $fileinfo->suffix;
                        } else {
                            $suffix_flag = empty($flag) ? '_s' : '_' . $flag;
                            $file_path = $directory . DIRECTORY_SEPARATOR . $real_hash_id . $suffix_flag . '.' . $fileinfo->suffix;
                        }
                    }else{
                        $file_path = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '.' . $fileinfo->suffix;
                    }
                    if(file_exists($file_path)){

                        header("Content-type: ".$fileinfo->file_type); //返回的文件
                        header("Accept-Ranges: bytes");   //按照字节大小返回
                        header("Accept-Length: " . $fileinfo->file_size); //返回文件大小

                        echo file_get_contents($file_path);

                        $this->ret['retData'] = 'image binary content';
                        return true;
                    }
                }
            }
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = "file not exist!";
            return $this->echojson($this->ret);
        }else{
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = "token is invalid!";
            return $this->echojson($this->ret);
        }

    }

    /**
     * 对图片进行缩放
     * @param string $image_file : image file 完整物理路径地址
     * @param array $arr
     * @param array $quality 质量，默认90
     * 单张图片：$arr = array('w'=>120, 'h'=>90); 或 $arr = array(array(120,90); 或 array(120,90);
     * 大小图片，即两张图片：$arr = array(array(400,300),array(120,90)); array(400,300)为大图宽高，array(120,90)为小图宽高
     * 大中小图，即三张图片：$arr = array(array(1200,900),array(400,300),array(120,90)); 依次为大中小图的尺寸大小
     * @return string $url 或 略缩图url
     * 当为多张图片时，则只返回最小图片,最小图片名称以 s_ 前缀。
     * 大图以 b_ 前缀
     * 中图以 m_ 前缀，大图和中图 需要根据小图地址进行转化而得到，如：str_replace('s_','b_', $smallpic);
     */
    private function imageScaling($image_file, $arr = array(), $quality = 90){

        $image = Image::instance($image_file);
        $has_small = false;//是否有略缩图

        if (isset($arr['w']) || isset($arr['h']) || is_numeric($arr[0])){
            $width = @$arr['w'] || @$arr[0] || NULL;
            $height = @$arr['h'] || @$arr[1] || NULL;
            $image->resize($width, $height)->save(NULL, $quality);
            $count = 1;
        }else{

            $last_point = strripos($image_file, '.');
            $prefix = substr($image_file, 0, $last_point);
            $suffix = substr($image_file, $last_point+1);

            $count = count($arr);
            if (1 == $count){
                $arr = $arr[0];
                $image->resize(isset($arr[0])?$arr[0]:null, isset($arr[1])?$arr[1]:null)->save(NULL, $quality);
            }elseif (2 == $count){

                $image->resize(@$arr[0][0],@$arr[0][1])->save($prefix.'_b'.'.'.$suffix, $quality);
                $image->resize(@$arr[1][0],@$arr[1][1])->save($prefix.'_s'.'.'.$suffix, $quality);
                $has_small = true;
            }elseif (3 == $count){
                $image->resize(@$arr[0][0],@$arr[0][1])->save($prefix.'_b'.'.'.$suffix, $quality);
                $image->resize(@$arr[1][0],@$arr[1][1])->save($prefix.'_m'.'.'.$suffix, $quality);
                $image->resize(@$arr[2][0],@$arr[2][1])->save($prefix.'_s'.'.'.$suffix, $quality);
                $has_small = true;
            }else{
                return false;
            }
        }

        if ($has_small){
            $filesmall = $prefix.'_s'.'.'.$suffix;
            $return_url = str_replace(DOCROOT.DIRECTORY_SEPARATOR, F::config('domain'), $filesmall);
            //删除原图
            unlink($image_file);
        }else{
            $return_url = str_replace(DOCROOT.DIRECTORY_SEPARATOR, F::config('domain'), $image_file);
        }
        return array('count'=>$count, 'url'=>$return_url);
    }

    /**
     * 删除文件或图片
     *
     * @param string $hash_id 文件唯一标识
     * @return boolean
     */
    public function delete_Action($hash_id = ''){

        //token正常且在有效时间内, 有效时间为300秒

        $fileinfo = new fileinfo_Model();
        $fileinfo->getByHashId($hash_id);
        if ($fileinfo->id && $this->account_id == $fileinfo->account_id) {
            if($fileinfo->is_encrpt){
                $real_hash_id = F::authstr($hash_id, 'DECODE');
            }else{
                $real_hash_id = $hash_id;
            }
            // 组装文件路径
            $directory = Upload::getDirectory($real_hash_id);

            if(in_array($fileinfo->suffix, array('png','jpg','gif'))){
                if($fileinfo->extend_text){
                    $extend_text = json_decode($fileinfo->extend_text, true);
                    if($extend_text['count'] == 1){
                        $file_path = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '.' . $fileinfo->suffix;
                        file_exists($file_path) && @unlink($file_path);
                    }elseif($extend_text['count'] == 2){
                        $file_path1 = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '_s.' . $fileinfo->suffix;
                        $file_path2 = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '_b.' . $fileinfo->suffix;

                        file_exists($file_path1) && @unlink($file_path1);
                        file_exists($file_path2) && @unlink($file_path2);
                    }elseif($extend_text['count'] == 3){
                        $file_path1 = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '_s.' . $fileinfo->suffix;
                        $file_path2 = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '_m.' . $fileinfo->suffix;
                        $file_path3 = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '_b.' . $fileinfo->suffix;

                        file_exists($file_path1) && @unlink($file_path1);
                        file_exists($file_path2) && @unlink($file_path2);
                        file_exists($file_path3) && @unlink($file_path3);
                    }
                }


            }else {
                //真实文件路径
                $file_path = $directory . DIRECTORY_SEPARATOR . $real_hash_id . '.' . $fileinfo->suffix;
                file_exists($file_path) && @unlink($file_path);
            }

            $fileinfo->delete();

            $this->ret['retData'] = 'delete ok';
            return $this->echojson($this->ret);
        }
        $this->ret['errNum'] = 1;
        $this->ret['errMsg'] = "file not exist!";
        return $this->echojson($this->ret);


    }



}
