<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示logtype</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示logtype</h2>
<p><strong>日志类型名称: </strong><?php echo $logtype->type_name;?></p>
<p><strong>描述: </strong><?php echo $logtype->description;?></p>
<p><strong>日志数: </strong><?php echo $logtype->records_count;?></p>
<p><strong>创建时间: </strong><?php echo $logtype->created_time;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
