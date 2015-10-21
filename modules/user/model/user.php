<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * user模型
* @author zhengshufa
* @date 2015-10-19 16:45:20
 */
class user_Model extends Model{

protected $table = 'user';
protected $primary = 'id';
protected $fileds = array(
'id'=>0,
'account'=>'',
'passwd'=>'1',
'regtime'=>'0000-00-00 00:00:00',
'logtime'=>'0000-00-00 00:00:00',
'logip'=>'127.0.0.1',
);
}
