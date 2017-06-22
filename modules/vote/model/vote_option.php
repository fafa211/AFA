<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * vote_option模型
 * @author zhengshufa
 * @date 2017-04-07 21:17:22
 */
class vote_option_Model extends Model
{

    protected $module = 'vote';
    protected $table = 'vote_options';
    protected $primary = 'id';
    protected $fileds = array(
        'id' => 0,
        'vote_id' => '',
        'option_title' => '',
        'option_pic' => '',
        'option_text'=>'',
        'votes' => 0,
        'add_time' => '',
    );


    /**
     *
     * 查询投票选项
     *
     * @param $vote_id  投票ID
     * @param $where    查询条件
     * @param $orderby  排序,  $orderby 为false时,表示读取条数
     * @return array 查询结果
     */
    public function search($vote_id, $where = array(), $orderby = "id asc"){

        $sql = Sql::select('*', $this->table, array('vote_id' => $vote_id))
            ->where($where)
            ->orderby($orderby)
            ->render();
        return $this->db->query($sql);

    }

    /**
     *
     * 查询投票选项
     *
     * @param $vote_id  投票ID
     * @return array 查询结果
     */
    public function getVoteNum($vote_id){

        $sql = Sql::select('SUM(votes) as vote_num', $this->table, array('vote_id' => $vote_id))
            ->render();

        $result_num = $this->db->getOne($sql);

        return $result_num?$result_num:0;

    }

}
