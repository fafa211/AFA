<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * comment模型
* @author zhengshufa
* @date 2015-10-20 14:49:53
 */
class comment_Model extends Model{

protected $table = 'blog_comments';
protected $primary = 'id';
protected $fileds = array(
'id'=>0,
'blog_id'=>'',
'content'=>'',
'addtime'=>'0000-00-00 00:00:00',
'ip'=>'127.0.0.1',
);
}
