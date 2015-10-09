<?php

class User_Model extends Model{
    
    //数据表名称
    protected $table = 'user';
    
    //主键字段
    protected $primary = 'id';
    
    //字段设置
    protected $fileds  = array(
        'id'=>0,//自增ID
        'account'=>'',//账号
        'passwd'=>'',//密码
        'regtime'=>'0000-00-00 00:00:00',//注册时间
        'logtime'=>'0000-00-00 00:00:00',//登录时间
        'logip'=>'000.000.000.000'//登录IP
    );
    
    /**
     * 通过账号读取信息
     * @param string $account: the user account
     */
    public function get($account){
        $sql = 'select * from `'.$this->table.'` where account="'.addslashes($account).'"';
        $rs = $this->db->getOneResult($sql);
        
        foreach ($rs as $k=>$v){
            $this->$k = $v;
        }
        return $this;
    }
    
}