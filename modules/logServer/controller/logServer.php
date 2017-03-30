<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * logtype模型控制器
 * @author zhengshufa
 * @date 2016-09-09 16:27:22
 */
class LogServer_Controller extends Server_Controller
{

    /**
     * 新增logtype
     *
     * array $values  POST 传输, 键值对数组
     * 需要传的参数为
     *
     * $type_id  日志类型ID
     *
     * 用户自定义字段内容
     *
     */
    public function add_Action($type_id = 0)
    {
        $logtype = new logtype_Model($type_id);
        if($logtype->account_id == $this->account_id){

            $logtype_property = new logtype_property_Model();
            $property_arr = $logtype_property->find_cols($type_id);

            //模型名称
            $model_name = 'common_log_record_'.$this->account_id.'_'.$type_id;
            $model_file = F::find_file('model', $model_name, $this->request->module);
            if(file_exists($model_file)){
                include_once $model_file;
                $model_name .= '_Model';

                $log_record = new $model_name();
                $log_record->cl_account_id  = $this->account_id;
                $log_record->cl_type_id     = $type_id;
                $log_record->cl_client_ip   = $this->client_ip;
                $log_record->cl_created_time= time();

                //用户使用post传值过来进行验证并赋值
                $post = input::post();
                foreach ($property_arr as $arr) {
                    $check_has = false;
                    foreach ($post as $key => $value) {
                        if ($arr['col_name'] == $key) {
                            $log_record->$key = $value;
                            $check_has = true;
                            break;
                        }
                    }
                    //缺少参数
                    if(!$check_has){
                        $this->ret['errMsg'] = '缺少参数 '.$arr['col_name'];
                        $this->ret['errNum'] = 1;

                        return $this->echojson($this->ret);
                    }
                }

                //保存入库
                $log_record->save();
                return $this->echojson($this->ret);
            }else{
                $this->ret['errMsg'] = '日志类型不存在!';
            }

        }else{
            $this->ret['errMsg'] = '你没有权限访问!';
        }

        $this->ret['errNum'] = 1;

        return $this->echojson($this->ret);

    }


    /**
     *
     * 查询日志详情-列表
     *
     * POST传输值:
     *
     * $start_time, 开始时间,时间戳
     * $end_time, 结束时间,时间戳
     * $conditions = array() 键值对数组,json encode 处理
     *
     * @param $type_id  日志类型ID
     * @param $page 当前页码
     * @param $page_size 每页展示数量
     *
     * @return string json array
     */
    public function lists_Action($type_id, $page_num = 1, $page_size = 10)
    {
        $logtype = new logtype_Model($type_id);
        if($logtype->account_id == $this->account_id){

            //模型名称
            $model_name = 'common_log_record_'.$this->account_id.'_'.$type_id;
            $model_file = F::find_file('model', $model_name, $this->request->module);
            if(file_exists($model_file)){

                $logtype_property = new logtype_property_Model();
                $property_arr = $logtype_property->find_cols($type_id);

                //用户使用post传值过来进行验证并赋值
                $post = input::post();
                $where = array();
                foreach ($post as $key => $value) {
                    foreach ($property_arr as $arr) {
                        if ($arr['col_name'] == $key) {
                            $where[$arr['col_name']] = $value;
                            break;
                        }
                    }
                }

                $this->ret['retData'] = $logtype_property->find_common_logs(
                    $model_name, //数据表明
                    $page_num, //当前页码
                    $page_size, //单页数量
                    intval(input::post('start_time')),//开始时间
                    input::post('end_time')?intval(input::post('end_time')):time(),//结束时间
                    $where //其他条件
                );

                return $this->echojson($this->ret);
            }else{
                $this->ret['errMsg'] = '日志类型不存在!';
            }

        }else{
            $this->ret['errMsg'] = '你没有权限访问!';
        }

        $this->ret['errNum'] = 1;

        return $this->echojson($this->ret);
    }

    /**
     * 展示logtype具体子段
     *
     * @param $type_id 日志类型ID
     * @param $col_name 日志具体字段
     *
     * @return string 返回用户自定义具体字段说明文字
     */
    public function show_Action($type_id, $col_name)
    {
        $logtype = new logtype_Model($type_id);
        if($logtype->account_id == $this->account_id){

            $logtype_property = new logtype_property_Model();
            $logtype_property->get_by_col_name($type_id, $col_name);
            $this->ret['retData'] = $logtype_property->display_name;

            return $this->echojson($this->ret);

        }else{
            $this->ret['errMsg'] = '你没有权限访问!';
        }

        $this->ret['errNum'] = 1;

        return $this->echojson($this->ret);


    }

    /**
     * 展示logtype全部字段
     *
     * @param $type_id 日志类型ID
     *
     * @return string 返回此日志类型全部用户自定义字段说明文字 json
     */
    public function showFileds_Action($type_id)
    {
        $logtype = new logtype_Model($type_id);
        if($logtype->account_id == $this->account_id){

            $logtype_property = new logtype_property_Model();
            $result = $logtype_property->find_cols($type_id);
            $simple_result = array();
            foreach($result as $key=>$value){
                $simple_result[$key] = array('filed_name'=>$value['col_name'], 'comment'=>$value['display_name']);
            }

            $this->ret['retData'] = $simple_result;

            return $this->echojson($this->ret);

        }else{
            $this->ret['errMsg'] = '你没有权限访问!';
        }

        $this->ret['errNum'] = 1;

        return $this->echojson($this->ret);


    }

}
