<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * iparea模型
 * @author zhengshufa
 * @date 2016-08-02 15:20:55
 */
class iparea_Model extends Model
{

    protected $module = 'iparea';
    protected $table = 'ip_areas';
    protected $primary = 'ip';
    protected $fileds = array(
        'ip' => 0,
        'country' => '',
        'province' => '',
        'city' => '',
        'county' => '',
        'isp' => '',
    );
}
