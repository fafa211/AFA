<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * logtype_property模型控制器
 * @author zhengshufa
 * @date 2016-09-08 16:27:22
 */
class logtype_property_Controller extends Admin_Controller
{

    private $vdir = 'logtype_property/';

    /**
     * 新增logtype_property
     */
    public function add_Action()
    {
        if (input::post()) {
            $post = input::post();
            $logtype_property = new logtype_property_Model();
            foreach ($post as $k => $v) {
                $logtype_property->$k = is_array($v) ? join(',', $v) : $v;
            }
            $logtype_property->save();
            $this->echomsg('新增成功!', 'lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'add');
        $view->render();
    }

//    /**
//     * 删除logtype_property
//     */
//    public function delete_Action($id)
//    {
//        $logtype_property = new logtype_property_Model($id);
//        if ($logtype_property->id) {
//            $logtype_property->delete($id);
//            $this->echomsg('删除成功!', '../lists');
//        } else {
//            $this->echomsg('删除失败!', '../lists');
//        }
//    }

    /**
     * 修改logtype_property
     */
    public function edit_Action($id)
    {
        $logtype_property = new logtype_property_Model($id);
        if (input::post()) {
            $post = input::post();
            foreach ($post as $k => $v) {
                $logtype_property->$k = is_array($v) ? join(',', $v) : $v;
            }
            $logtype_property->save();
            $this->echomsg('修改成功!', '../lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'edit');
        $view->logtype_property = $logtype_property;
        $view->render();
    }

    /**
     * 列表管理 logtype_property
     */
    public function lists_Action()
    {
        $logtype_property = new logtype_property_Model();
        $view = &$this->view;
        $view->set_view($this->vdir . 'lists');
        $view->lists = $logtype_property->lists('0,10');
        $view->list_fields_arr = array('id', 'type_id', 'prop_name', 'col_name', 'display_name', 'data_type', 'created_time');
        $view->render();
    }

    /**
     * 展示logtype_property
     */
    public function show_Action($id)
    {
        $logtype_property = new logtype_property_Model($id);
        $view = &$this->view;
        $view->set_view($this->vdir . 'show');
        $view->logtype_property = $logtype_property;
        $view->render();
    }

    /**
     * 创新新的日志
     */
    public function create_Action(){

        //用户日志自定义日志
        $log_type = 'login';

        $fileds_first_common = $this->sysFiledConfig('first');
        $fileds_last_common = $this->sysFiledConfig('last');

        //登录日志
        $fileds_settings = $this->userFiledConfig($log_type);

        $type_id = 1;
        $account_id = 1;
        $table_name = 'common_log_record_'.$account_id.'_'.$type_id;

        $sql = 'CREATE TABLE '.$table_name.' (';
        $sql = $this->catsql($fileds_first_common, $sql);
        $sql = $this->catsql($fileds_settings, $sql);
        $sql = $this->catsql($fileds_last_common, $sql);
        $sql = $this->catsqlKey($fileds_first_common, $sql);
        $sql = $this->catsqlKey($fileds_settings, $sql);
        $sql = $this->catsqlKey($fileds_last_common, $sql);

        $sql = substr($sql, 0, -1);
        $sql .= ' ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\''.$this->userTableComment($log_type).'\'';

        $logtype_property = new logtype_property_Model();
        $logtype_property->exec($sql);


        //插入相应属性值
        $time = date('Y-m-d H:i:s');
        foreach($fileds_settings as $arr){
            $logtype_property = new logtype_property_Model();
            $logtype_property->get_by_col_name($type_id, $arr['name']);

            //已经存在了
            if($logtype_property->id) continue;

            $logtype_property->type_id = $type_id;
            $logtype_property->prop_name = $arr['name'];
            $logtype_property->col_name = $arr['name'];
            $logtype_property->display_name = $arr['comment'];
            $logtype_property->data_type = $arr['data_type'];
            $logtype_property->created_time = $time;

            $logtype_property->save();
        }

        $fileds = array_merge($fileds_first_common, $fileds_settings, $fileds_last_common);
        $this->createModel($table_name, $table_name, $fileds);

        $this->echomsg("模型生成成功!");

    }

    /**
     * 根据配置的数组生成创建数据表的SQL
     *
     * @param $arr
     * @param string $sql
     * @return string
     */
    private function catsql($arr, $sql = ''){

        foreach($arr as $subarr){
            $sql .= $subarr['name'].' ';
            $sql .= $subarr['data_type'].' NOT NULL ';

            if($subarr['index'] && 'primary' == $subarr['index'] && 'int' == substr($subarr['data_type'], 0, 3)){
                $sql .= ' AUTO_INCREMENT ';
            }else{
                $sql .= 'DEFAULT \''.$subarr['default_value'].'\' ';
            }
            $sql .= 'COMMENT \''.$subarr['comment']. '\',';
        }

        return $sql;
    }

    /**
     * 根据配置的数组生成创建数据表的SQL
     *
     * @param $arr
     * @param string $sql
     * @return string
     */
    private function catsqlKey($arr, $sql = ''){
        foreach($arr as $subarr) {
            if ($subarr['index']) {
                if ('primary' == $subarr['index']) {
                    $sql .= ' PRIMARY KEY (`' . $subarr['name'] . '`),';
                } elseif ('key' == $subarr['index']) {
                    $sql .= ' KEY `idx_' . $subarr['name'] . '` (`' . $subarr['name'] . '`),';
                } elseif ('unique' == $subarr['index']) {
                    $sql .= ' UNIQUE KEY `idx_' . $subarr['name'] . '` (`' . $subarr['name'] . '`),';
                }
            }
        }

        return $sql;
    }

    /**
     * 独立生成具体日志model
     *
     * @param $model
     * @param $table
     * @param array $fileds
     */
    private function createModel($model, $table, $fileds = array()){
        $module = 'logServer';//模型名称
        $prikey = 'cl_id';//主键名

        F::load('codemaker', 'codemaker');
        //F::find_file('helper', 'codemaker', 'logServer');
        $maker = new codemaker($module, $model, $table, $prikey, $fileds);
        $maker->store_model();

    }

    /**
     * 日志记录表公用配置,无需变动
     *
     * @param string $flag
     * @return array
     */
    private function sysFiledConfig($flag = 'first'){
        if('first' == $flag){
            return array(
                        array(
                            'name'=>'cl_id',//字段名称
                            'data_type'=>'int(11)',//字段类型
                            'comment'=>'自增ID',//说明
                            'index'=>'primary',//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                            'default_value'=>0 //默认值
                        ),
                        array(
                            'name'=>'cl_account_id',//字段名称
                            'data_type'=>'int(11)',//字段类型
                            'comment'=>'帐号ID',//说明
                            'index'=>false,//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                            'default_value'=>0 //默认值
                        ),
                        array(
                            'name'=>'cl_type_id',//字段名称
                            'data_type'=>'int(11)',//字段类型
                            'comment'=>'日志类型id',//说明
                            'index'=>false,//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                            'default_value'=>0 //默认值
                        ),
                        array(
                            'name'=>'cl_client_ip',//字段名称
                            'data_type'=>'varchar(32)',//字段类型
                            'comment'=>'客户所在IP',//说明
                            'index'=>false,//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                            'default_value'=>'127.0.0.1' //默认值
                        )
            );
        }elseif('last' == $flag){
            return array(
                        array(
                            'name'=>'cl_created_time',//字段名称
                            'data_type'=>'int(11)',//字段类型
                            'comment'=>'日志记录时间',//说明
                            'index'=>false,//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                            'default_value'=>0 //默认值
                        )
            );
        }
    }


    /**
     * 日志记录表配置
     * 具体类型日志配置,每种日志都不一样
     *
     * @param string $flag
     * @return array
     */
    private function userFiledConfig($type){
        switch($type){
            case 'login': //登录日志
                return array(
                    array(
                        'name'=>'user_id',//字段名称
                        'data_type'=>'int(11)',//字段类型
                        'comment'=>'用户ID',//说明
                        'index'=>false,//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                        'default_value'=>0 //默认值
                    ),
                    array(
                        'name'=>'user_ip',//字段名称
                        'data_type'=>'varchar(32)',//字段类型
                        'comment'=>'用户登录IP',//说明
                        'index'=>false,//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                        'default_value'=>'' //默认值
                    ),
                    array(
                        'name'=>'login_time',//字段名称
                        'data_type'=>'int(11)',//字段类型
                        'comment'=>'登录时间',//说明
                        'index'=>false,//索引,非索引字段使用false, 主建用primary key, 普通索引用key
                        'default_value'=>0 //默认值
                    ),
                );
            break;

            case 'other':
                return array(
                    array()
                );
        }
    }

    /**
     * 日志记录表配置
     * 具体类型日志配置,每种日志都不一样
     *
     * @param string $flag
     * @return array
     */
    private function userTableComment($type){
        switch($type){
            case 'login': //登录日志
                return '登录日志表';
            break;

            case 'other':
                return '';
        }
    }

}
