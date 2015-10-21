<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示user</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示user</h2>
<p><strong>账号: </strong><?php echo $user->account;?></p>
<p><strong>密码: </strong><?php echo $user->passwd;?></p>
<p><strong>注册时间: </strong><?php echo $user->regtime;?></p>
<p><strong>登录时间: </strong><?php echo $user->logtime;?></p>
<p><strong>登录ip: </strong><?php echo $user->logip;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
