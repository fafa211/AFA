<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * idcarea模型
 * @author zhengshufa
 * @date 2016-07-26 16:51:59
 */
class idcarea_Model extends Model
{

    protected $module = 'idcarea';
    protected $table = 'idcard_areas';
    protected $primary = 'id';
    protected $fileds = array(
        'id' => 0,
        'address' => '',
        'the_level' => '3',
        'name' => '',
    );
}
