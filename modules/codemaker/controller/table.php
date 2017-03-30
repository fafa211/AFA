<?php defined('AFA') or die('No AFA PHP Framework!');


/**
 * 模块代码生成器 - 从数据表生成
 * @see        https://github.com/fafa211/AFA-PHP
 * @author     郑书发 <22575353@qq.com>
 * @category   Core
 * @package    module
 * @copyright  Copyright (c) 2015-2016 afaphp.com
 * @license    http://www.afaphp.com/license.html
 */

class Table_Controller extends Controller{


    /**
     * model setting
     */
    public function index_Action(){
        $this->view->set_view('index');
        $this->view->render();
    }

    /**
     * module maker
     */
    public function maker_Action(){

        $this->makerAuthor();

        $this->echomsg("模型生成成功!");
    }


    /**
     * 用数据表结构直接创建模块代码
     * 只需要数据结构表的名称即可生成整个模块代码
     *
     */
    private function makerAuthor(){
        //////基本设置 -START //////
        $module = 'author';//模型名称
        $model = 'author';//通常与表名一致，也可以不一样，将生成 $model_Controller 和 $model_Model类文件
        $table = 'authors';//表名
        $prikey = 'id';//主键名
        //////基本设置 - END//////

        //////字段设置 -START //////
        //不能为空字段
        $require_arr = array('author', 'sex', 'age');
        //列表展示字段
        $list_arr = array('author', 'sex', 'age', 'ctime');
        //创建页面需要填写字段
        $create_arr = array('author', 'sex', 'age');
        //编辑页面需要填写字段
        $edit_arr = array('author', 'sex', 'age', 'love');
        //特殊配置
        $fileds_arr = array(
            'age'=> array(
                'pattern' => "[0-9]{1,11}",//pattern出现时，title必须配对出现
                'title' => "文件大小,必须为数字"
            ),
            'ctime'=>array(
                'pattern' => "[0-9]{1,11}",//pattern出现时，title必须配对出现
                'title' => "创建时间戳,必须为数字"
            )
        );
        //////字段设置 -END //////

        $fileds = $this->findFiledsSetting($table, $require_arr, $create_arr, $edit_arr, $list_arr, $fileds_arr);

        //创建模块
        $maker = new codemaker($module, $model, $table, $prikey, $fileds);
        $maker->store();
    }


    /**
     * 用数据表结构直接创建模块代码
     * 只需要数据结构表的名称即可生成整个模块代码
     *
     * @param $module   模型名称
     * @param $model    通常与表名一致，也可以不一样，将生成 $model_Controller 和 $model_Model类文件
     * @param $table    表名
     * @param $prikey   主键名
     * @param array $require_arr    不能为空字段
     * @param array $add_arr        新增页面需要填写字段
     * @param array $edit_arr       编辑页面需要填写字段
     * @param array $list_arr       列表展示字段
     * @param array $fileds_arr      字段特殊配置
     *
     */
    private function findFiledsSetting($table, $require_arr = array(), $add_arr = array(), $edit_arr = array(), $list_arr = array(), $fileds_arr = array()){
        $cmodel = new Model();
        $sql = "SHOW FULL COLUMNS FROM `{$table}`";
        $rs = $cmodel->db->query($sql);


        $fileds = array();

        foreach($rs as $k=>$v){
            $comment = $this->parse($v['Comment']);
            $single = array(
                'name'=> $v['Field'],
                'cnname'=> $comment['cnname'],
                'type'=> $comment['type'],
                'type_extend' => $comment['type_extend'],
                'required' => in_array($v['Field'], $require_arr)?true:false,
                'is_add' => in_array($v['Field'], $add_arr)?true:false,
                'is_edit' => in_array($v['Field'], $edit_arr)?true:false,
                'list_show' => in_array($v['Field'], $list_arr)?true:false,
                'default_value' => $v['Default']
            );

            if(isset($fileds_arr["{$v['Field']}"])){
                foreach($fileds_arr["{$v['Field']}"] as $key=>$value){
                    $single[$key] = $value;
                }
            }
            array_push($fileds, $single);
        }

        return $fileds;
    }



    /**
     *
     * 表结构的字段定义的 COMMENT 解析
     *
     * 注意:在建数据表结构时需要遵循以下规则:
     * 1. 必须要有注释;
     * 2. 注释规则为: 注释内容以竖线符号进行块分割, 规则为: 中文现实名称|表单类型|是否可编辑|扩展内容|其他注释
     * 3. 除中文现实名称必须有外,其他均为可选填内容, 具体事例为:  性别|radio|1|1=>男, 2=>女
     * 此事例中, 性别为中文名称, radio为表单类型, 1表示可以编辑, "1=>男, 2=>女" 为扩展内容,  其他注释为空
     * 4. 表单类型 - 字段类型，主要有:input,password,url,tel,email,textarea,radio,checkbox,select,file 等
     *
     * @param $comment 解析COMMENT内容
     * @return array,  默认返回 array('cnname'=>$comment, 'type'=>'text', 'extend'=>'')
     */
    private function parse($comment){

        $first_pos = strpos($comment, '|');

        //返回结果格式
        $rt = array('cnname'=>$comment, 'type'=>'text', 'type_extend'=>'');
        //表单字段类型
        $type_arr = explode(',', "text,input,password,url,tel,email,textarea,radio,checkbox,select,file");

        if($first_pos === false){
            return $rt;
        }

        $comment_arr = explode('|', $comment);
        //字段中文名称
        $rt['cnname'] = trim($comment_arr[0]);
        if(isset($comment_arr[1]) && in_array($comment_arr[1], $type_arr)){
            //表单类型
            $rt['type'] = trim($comment_arr[1]);
        }
        if(isset($comment_arr[2])){
            //扩展内容
            $extend = array();
            $other = explode(',', trim($comment_arr[2]));
            foreach($other as $v){
                list($key, $value) = explode('=>', $v);
                $extend[trim($key)] = trim($value);
            }
            $rt['type_extend'] = empty($extend)?trim($comment_arr[3]):$extend;
        }

        return $rt;

    }


}