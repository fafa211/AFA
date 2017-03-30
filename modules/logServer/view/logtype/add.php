<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>新增logtype</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>新增logtype</h2>
<form method='post' >
<div class="form-group">
<label name="type_name" for="inputtype_name" class="control-label">日志类型名称</label>
<input type="text" name="type_name" class="form-control" id="inputtype_name" placeholder="日志类型名称" value="" required>
</div>
<div class="form-group">
<label name="description" for="inputdescription" class="control-label">描述</label>
<input type="text" name="description" class="form-control" id="inputdescription" placeholder="描述" value="" required>
</div>
<button type="sumbit" class="btn btn-default">提交</button>
</form>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
