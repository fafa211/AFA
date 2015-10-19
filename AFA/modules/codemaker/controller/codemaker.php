<?php defined('AFA') or die('No AFA PHP Framework!');


/**
 * 模块代码生成器
 * @author zhengshufa
 * @date 2015-10-13
 *
 */

class codemaker_Controller extends Controller{
    
    
    /**
     * model setting
     */
    public function index(){
        $view = new View('index');
        $view->render();
    }
    
    /**
     * module maker
     */
    public function maker(){
        
        $module = 'user';//模型名称
        $table = 'user';//表名
        $prikey = 'id';//主键名
        /**$fileds = array(
            array(
                'name' => 'title',//字段名称
                'cnname' => '标题',//字段中文名称(描述)
                'type' => 'text',//表单类型 - 字段类型，如:input,password,url,tel,email,textarea,radio,checkbox,select,file 等
                'type_extend' => '',//类型辅助扩展内容，没有则为空, radio,checkbox,select时为数组
                'required'=>true,//true 不为空 false 可以为空
                'is_edit'=>true, //是否可编辑
                'list_show'=>true,//列表显示时是否显示
                'default_value' => ''//默认值
            ),
            array(
                'name' => 'content',
                'cnname' => '内容',
                'type' => 'textarea',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>false,
                'default_value' => ''
            ),
            array(
                'name' => 'author',
                'cnname' => '作者',
                'type' => 'text',
                'type_extend' => '',
                'required'=>false,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => ''
            ),
            array(
                'name' => 'ctime',
                'cnname' => '发布时间',
                'type' => 'datetime',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => '0000-00-00 00:00:00'
            ),
            array(
                'name' => 'email',
                'cnname' => 'Email',
                'type' => 'email',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => ''
            ),
            array(
                'name' => 'sex',
                'cnname' => '性别',
                'type' => 'radio',
                'type_extend' => array(1=>'十足的男性',2=>'十足的女性',3=>'有时呈男性，有时呈女性',4=>'既不呈男性，也不呈女性'),
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => '1'
            ),
            array(
                'name' => 'love',
                'cnname' => '爱好',
                'type' => 'checkbox',
                'type_extend' => array(1=>'无尽的编程',2=>'无尽的游玩',3=>'无尽的睡觉',4=>'无尽的发呆',5=>'无尽的购物'),
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => '1'
            ),
            array(
                'name' => 'salary',
                'cnname' => '薪水',
                'type' => 'select',
                'type_extend' => array(1=>'月薪1000以下',2=>'月薪1000 ~ 10000',3=>'月薪10000以上'),
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => '1'
            ),
            array(
                'name' => 'headpic',
                'cnname' => '头像',
                'type' => 'file',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>false,
                'default_value' => '1'
            )
        );
        **/
        
        $fileds = array(
            array(
                'name' => 'account',
                'cnname' => '账号',
                'type' => 'text',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => ''
            ),
            array(
                'name' => 'passwd',
                'cnname' => '密码',
                'type' => 'password',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>true,
                'list_show'=>true,
                'default_value' => '1'
            ),
            array(
                'name' => 'regtime',
                'cnname' => '注册时间',
                'type' => 'datetime',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>false,
                'list_show'=>true,
                'default_value' => '0000-00-00 00:00:00'
            ),
            array(
                'name' => 'logtime',
                'cnname' => '登录时间',
                'type' => 'datetime',
                'type_extend' => '',
                'required'=>true,
                'is_edit'=>false,
                'list_show'=>true,
                'default_value' => '0000-00-00 00:00:00'
            ),
            array(
                'name' => 'logip',
                'cnname' => '登录ip',
                'type' => 'text',
                'type_extend' => '',
                'required'=>false,
                'is_edit'=>false,
                'list_show'=>true,
                'default_value' => '127.0.0.1'
            )
        );
        
        $maker = new codemaker($module, $table, $prikey, $fileds);
        $maker->store();//把生成结果保存到文件中
        
        $this->echomsg($module.' 模型生成成功!');
    }
    
}