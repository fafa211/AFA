<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示iparea</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示iparea</h2>
<p><strong>国家: </strong><?php echo $iparea->country;?></p>
<p><strong>省份: </strong><?php echo $iparea->province;?></p>
<p><strong>城市: </strong><?php echo $iparea->city;?></p>
<p><strong>地区: </strong><?php echo $iparea->county;?></p>
<p><strong>运营商: </strong><?php echo $iparea->isp;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
