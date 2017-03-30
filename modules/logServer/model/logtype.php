<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * logtype模型
 * @author zhengshufa
 * @date 2016-09-08 16:27:22
 */
class logtype_Model extends Model
{

    protected $module = 'logServer';
    protected $table = 'common_log_type';
    protected $primary = 'id';
    protected $fileds = array(
        'id' => 0,
        'account_id'=>0,
        'type_name' => '',
        'description' => '',
        'records_count' => '0',
        'created_time' => '0000-00-00 00:00:00',
    );
}
