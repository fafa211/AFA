<?php

defined('AFA') or die('No AFA PHP Framework!');

/**
 * spproject模型
 * 
 * @author zhengshufa
 *         @date 2015-12-09 17:44:03
 */
class spproject_Model extends Model
{

    protected $module = 'spproject';

    protected $table = 'sp_project';

    protected $primary = 'id';

    protected $fileds = array(
        'id' => 0,
        'name' => '',
        'pic_url' => '',
        'moban_url' => '',
        'm_about1' => '',
        'm_about2' => '',
        'm_about3' => '',
        'phone_or_400' => '',
        'db_shangqiao_code' => '',
        'create_time' => '0000-00-00 00:00:00'
    );
}
