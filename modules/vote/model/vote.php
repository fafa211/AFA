<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * vote模型
 * @author zhengshufa
 * @date 2017-04-07 21:17:22
 */
class vote_Model extends Model
{

    protected $module = 'vote';
    protected $table = 'votes';
    protected $primary = 'id';
    protected $fileds = array(
        'id' => 0,
        'account_id' => '',
        'uid' => '',
        'qiye_id' => '',
        'type' => '1',
        'title' => '',
        'title_pic' => '',
        'about' => '',
        'start_time' => '',
        'end_time' => '',
        'option_setting' => '0',
        'rate' => '0',
        'add_time' => '',
    );


    /**
     *
     * 查询投票
     *
     * @param $account_id  授权账号ID
     * @param $qiye_id  企业(支队)ID
     * @param $where    查询条件
     * @param $orderby  排序,  $orderby 为false时,表示读取条数
     * @param string $limit 读取条数
     * @return array | int 查询结果 | 结果条数
     */
    public function search($account_id, $qiye_id, $where = array(), $orderby = "id desc", $limit = "0,10"){
        if($orderby === false){
            $sql = Sql::select('COUNT(id) AS result_num', $this->table, array('account_id' => $account_id, 'qiye_id' => $qiye_id))
                ->where($where);
            return $this->db->getOne($sql);
        }else {
            $sql = Sql::select('*', $this->table, array('account_id' => $account_id, 'qiye_id' => $qiye_id))
                ->where($where)
                ->orderby($orderby)
                ->limit($limit)
                ->render();
            return $this->db->query($sql);
        }
    }

}
