<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>新增phonearea</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>新增phonearea</h2>
<form method='post' >
<div class="form-group">
<label name="pref" for="inputpref" class="control-label">手机号码前7位</label>
<input type="text" name="pref" class="form-control" id="inputpref" placeholder="手机号码前7位" value="" required>
</div>
<div class="form-group">
<label name="province" for="inputprovince" class="control-label">省份</label>
<input type="text" name="province" class="form-control" id="inputprovince" placeholder="省份" value="" required>
</div>
<div class="form-group">
<label name="city" for="inputcity" class="control-label">城市</label>
<input type="text" name="city" class="form-control" id="inputcity" placeholder="城市" value="" required>
</div>
<div class="form-group">
<label name="isp" for="inputisp" class="control-label">运营商</label>
<input type="text" name="isp" class="form-control" id="inputisp" placeholder="运营商" value="" required>
</div>
<div class="form-group">
<label name="code" for="inputcode" class="control-label">区号</label>
<input type="text" name="code" class="form-control" id="inputcode" placeholder="区号" value="" required>
</div>
<div class="form-group">
<label name="zip" for="inputzip" class="control-label">邮编</label>
<input type="text" name="zip" class="form-control" id="inputzip" placeholder="邮编" value="" required>
</div>
<button type="sumbit" class="btn btn-default">提交</button>
</form>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
