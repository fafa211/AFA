<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * common_log_record_1_1模型
* @author zhengshufa
* @date 2016-09-09 11:27:40
 */
class common_log_record_3_1_Model extends Model{

protected $module = 'logServer';
protected $table = 'common_log_record_3_1';
protected $primary = 'cl_id';
protected $fileds = array(
'cl_id'=>0,
'cl_account_id'=>'0',
'cl_type_id'=>'0',
'cl_client_ip'=>'127.0.0.1',
'user_id'=>'0',
'user_ip'=>'',
'login_time'=>'0',
'cl_created_time'=>'0',
);
}
