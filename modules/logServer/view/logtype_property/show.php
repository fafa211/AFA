<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示logtype_property</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示logtype_property</h2>
<p><strong>日志类型ID: </strong><?php echo $logtype_property->type_id;?></p>
<p><strong>程序属性名称: </strong><?php echo $logtype_property->prop_name;?></p>
<p><strong>数据库字段名称: </strong><?php echo $logtype_property->col_name;?></p>
<p><strong>显示名称: </strong><?php echo $logtype_property->display_name;?></p>
<p><strong>数据类型: </strong><?php echo $logtype_property->data_type;?></p>
<p><strong>创建时间: </strong><?php echo $logtype_property->created_time;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
