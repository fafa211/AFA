<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * blog模型
* @author zhengshufa
* @date 2015-10-19 14:56:59
 */
class blog_Model extends Model{

protected $table = 'blog';
protected $primary = 'id';
protected $fileds = array(
'id'=>0,
'title'=>'',
'content'=>'',
'author'=>'',
'ctime'=>'0000-00-00 00:00:00',
'email'=>'',
'sex'=>'1',
'love'=>'1',
'salary'=>'1',
'headpic'=>'1',
);
}
