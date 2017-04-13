<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>列表管理 vote</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>列表管理 vote</h2>
<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<th>ID</th>
<th>企业(支队)ID</th>
<th>投票类型， 1 文字投票，2图文投票，3视频投票</th>
<th>投票标题</th>
<th>开始时间</th>
<th>结束时间</th>
<th>选项设置: 1 单选，2 最多选两项，3 最多选三项， 4 不限制</th>
<th>投票频率:1 每人一票，2每天一票</th>
<th>操作</th></tr>
</thead>
<tbody>
<?php foreach ($lists as $k=>$arr):?>
<tr>
<?php foreach ($arr as $k=>$v):?>
<?php if(in_array($k, $list_fields_arr)) {
$param = $k.'_arr';
if (isset($$param) && is_array($$param)){
echo '<td>'.F::findInArray($v, $$param).'</td>';
}else{
 echo '<td>'.$v.'</td>';}
}
?><?php endforeach;?>
<td><a href="show/<?php echo $arr['id'];?>">查看</a> <a href="edit/<?php echo $arr['id'];?>">修改</a> <a href="delete/<?php echo $arr['id'];?>">删除</a> </td></tr>
<?php endforeach;?>
</tbody>
</table>
</div>
<a href="add" class="col-md-1">新增</a> <a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
