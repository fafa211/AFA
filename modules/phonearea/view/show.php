<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示phonearea</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示phonearea</h2>
<p><strong>手机号码前7位: </strong><?php echo $phonearea->pref;?></p>
<p><strong>省份: </strong><?php echo $phonearea->province;?></p>
<p><strong>城市: </strong><?php echo $phonearea->city;?></p>
<p><strong>运营商: </strong><?php echo $phonearea->isp;?></p>
<p><strong>区号: </strong><?php echo $phonearea->code;?></p>
<p><strong>邮编: </strong><?php echo $phonearea->zip;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
