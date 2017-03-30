<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * phonearea模型
 * @author zhengshufa
 * @date 2016-08-03 18:28:53
 */
class phonearea_Model extends Model
{

    protected $module = 'phonearea';
    protected $table = 'phone_areas';
    protected $primary = 'id';
    protected $fileds = array(
        'id' => 0,
        'pref' => '',
        'province' => '',
        'city' => '',
        'isp' => '',
        'code' => '',
        'zip' => '',
    );

    /**
     * @param $pref  读取号码归属地
     */
    public function getByPref($pref){
        $sql = sql::select('*', $this->table, array('pref'=>$pref));
        $orm = $this->db->getOneResult($sql);
        if ($orm){
            foreach ($orm as $k => $v) {
                $this->$k = $v;
            }
        }
        return $this;
    }
}
