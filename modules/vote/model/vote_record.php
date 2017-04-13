<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * vote_records 模型
 * @author zhengshufa
 * @date 2017-04-07 21:17:22
 */
class vote_record_Model extends Model
{

    protected $module = 'vote';
    protected $table = 'vote_records';
    protected $primary = 'id';
    protected $fileds = array(
        'id' => 0,
        'uid' => '',
        'vote_id' => 0,
        'option_id' => 0,
        'add_time' => 0,
    );


    /**
     *
     * 查询投票选项
     *
     * @param $vote_id  投票ID
     * @param $where    查询条件
     * @param $orderby  排序,  $orderby 为false时,表示读取条数
     * @param $limit 读取条数
     * @return array 查询结果
     */
    public function search($vote_id, $where=array(), $orderby = "id desc", $limit = "0,100"){

        if($orderby === false){
            $sql = Sql::select('COUNT(id) AS result_num', $this->table, array('vote_id' => $vote_id))
                ->where($where);
            return $this->db->getOne($sql);
        }else {
            $sql = Sql::select('*', $this->table, array('vote_id' => $vote_id))
                ->where($where)
                ->orderby($orderby)
                ->limit($limit)
                ->render();
            return $this->db->query($sql);
        }

    }

    /**
     *
     * 查询我参与的投票
     *
     * @param $vote_id  投票ID
     * @param $limit 读取条数, $limit == false时读取总条数
     * @return array 查询结果
     */
    public function searchMyVotes($uid, $limit = "0,100"){

        if($limit === false){
            $sql = Sql::select('COUNT(DISTINCT vote_id) AS result_num', $this->table, array('uid' => $uid));
            return $this->db->getOne($sql);
        }else {
            $vote = new vote_Model();

            $sql = "select v.* FROM (
                      select * from (
                        select vote_id,id from {$this->table} WHERE  uid='{$uid}'order by id desc
                      ) as a group by a.vote_id
                    ) as vr".
                " inner join {$vote->table} as v on v.id=vr.vote_id
                order by vr.id desc
                limit $limit";

            return $this->db->query($sql);
        }

    }

}
