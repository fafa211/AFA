<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * user模型控制器
* @author zhengshufa
* @date 2015-10-19 16:45:20
 */
class user_Controller extends Controller{

/**
 * 新增user
 */
public function add(){
if (input::post()){
$post = input::post();
$user = new user_Model();
foreach ($post as $k=>$v){
	$user->$k = is_array($v)?join(',', $v):$v;
}$user->save();
$this->echomsg('新增成功!', 'lists');
}
$view = new View('add');
$view->render();
}

/**
 * 删除user
 */
public function delete($id){
$user = new user_Model($id);
if($user->id) {
$user->delete($id);
$this->echomsg('删除成功!', '../lists');
}else {
$this->echomsg('删除失败!', '../lists');
}
}

/**
 * 修改user
 */
public function edit($id){
$user = new user_Model($id);
if (input::post()){
$post = input::post();
foreach ($post as $k=>$v){
	$user->$k = is_array($v)?join(',', $v):$v;
}$user->save();
$this->echomsg('修改成功!', '../lists');
}
$view = new View('edit');
$view->user = $user;
$view->render();
}

/**
 * 列表管理 user
 */
public function lists(){
$user = new user_Model();
$view = new View('lists');
$view->lists = $user->lists('0,10');
$view->list_fields_arr = array('id','account','passwd','regtime','logtime','logip');
$view->render();
}

/**
 * 展示user
 */
public function show($id){
$user = new user_Model($id);
$view = new View('show');
$view->user = $user;
$view->render();
}

}
