<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * logtype_property模型
 * @author zhengshufa
 * @date 2016-09-08 16:27:22
 */
class logtype_property_Model extends Model
{

    protected $module = 'logServer';
    protected $table = 'common_log_type_property';
    protected $primary = 'id';
    protected $fileds = array(
        'id' => 0,
        'type_id' => '',
        'prop_name' => '',
        'col_name' => '',
        'display_name' => '',
        'data_type' => '',
        'created_time' => '0000-00-00 00:00:00',
    );

    public function exec($sql){
        return $this->db->exec($sql);
    }

    /**
     *
     * 通过 $type_id 与 $col_name 获取具体列信息
     *
     * @param $type_id
     * @param $col_name
     * @return $this
     */
    public function get_by_col_name($type_id, $col_name){
        $sql = sql::select('*', $this->table, array('type_id'=>$type_id, 'col_name'=>$col_name));
        $orm = $this->db->getOneResult($sql);
        if ($orm){
            foreach ($orm as $k => $v) {
                $this->$k = $v;
            }
        }
        return $this;
    }

    /**
     *
     * 通过 $type_id 获取其所属全部列列信息
     *
     * @param $type_id
     * @return $this
     */
    public function find_cols($type_id = 0){
        $sql = sql::select('*', $this->table, array('type_id'=>$type_id));
        return $this->db->query($sql);
    }

    /**
     * 查询日志记录
     *
     * @param string $table  数据表名
     * @param int $page  当前页码
     * @param int $page_size 单页数量
     * @param int $start_time 开始时间
     * @param int $end_time 结束时间
     * @param array $conditions
     * @return mixed
     */
    public function find_common_logs($table = '', $page = 1, $page_size = 10, $start_time = 0, $end_time = 0, $conditions =array()){

        if(empty($table)) return array();

        $sql = sql::select('*', $table);
        if($start_time) $sql->where('cl_created_time', '>=', $start_time);
        if($end_time) $sql->where('cl_created_time', '<=', $end_time);

        if(!empty($conditions)) {
            $sql->where($conditions);
        }
        $sql->orderby("cl_id DESC")->limit(($page-1)*$page_size, $page_size);

        return $this->db->query($sql);
    }


}
