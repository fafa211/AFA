<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>管理员登录</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>管理员登录</h2>
<form method='post' >
<div class="form-group">
<label name="account" for="inputaccount" class="control-label">账号</label>
<input type="text" name="account" class="form-control" id="inputaccount" placeholder="账号" value="" required>
</div>
<div class="form-group">
<label name="passwd" for="inputpasswd" class="control-label">密码</label>
<input type="password" name="passwd" class="form-control" id="inputpasswd" placeholder="密码" value="" required>
</div>

<button type="sumbit" class="btn btn-default">登录</button>
</form>
</div>
</body>
</html>
