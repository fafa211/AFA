<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>修改logtype_property</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>修改logtype_property</h2>
<form method='post' >
<div class="form-group">
<label name="type_id" for="inputtype_id" class="control-label">日志类型ID</label>
<input type="text" name="type_id" class="form-control" id="inputtype_id" placeholder="日志类型ID" value="<?php echo $logtype_property->type_id;?>" required>
</div>
<div class="form-group">
<label name="prop_name" for="inputprop_name" class="control-label">程序属性名称</label>
<input type="text" name="prop_name" class="form-control" id="inputprop_name" placeholder="程序属性名称" value="<?php echo $logtype_property->prop_name;?>" required>
</div>
<div class="form-group">
<label name="col_name" for="inputcol_name" class="control-label">数据库字段名称</label>
<input type="text" name="col_name" class="form-control" id="inputcol_name" placeholder="数据库字段名称" value="<?php echo $logtype_property->col_name;?>" required>
</div>
<div class="form-group">
<label name="display_name" for="inputdisplay_name" class="control-label">显示名称</label>
<input type="text" name="display_name" class="form-control" id="inputdisplay_name" placeholder="显示名称" value="<?php echo $logtype_property->display_name;?>" required>
</div>
<div class="form-group">
<label name="data_type" for="inputdata_type" class="control-label">数据类型</label>
<input type="text" name="data_type" class="form-control" id="inputdata_type" placeholder="数据类型" value="<?php echo $logtype_property->data_type;?>" required>
</div>
<button type="sumbit" class="btn btn-default">提交</button>
</form>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
