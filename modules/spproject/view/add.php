<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>新增spproject</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
	<div class="container">
		<h2>新增项目</h2>
		<form method='post' enctype="multipart/form-data">
			<div class="form-group">
				<label name="name" for="inputname" class="control-label">项目名称</label>
				<input type="text" name="name" class="form-control" id="inputname"
					placeholder="项目名称" value="" required>
			</div>
			<div class="form-group">
				<label name="pic_url" for="inputpic_url" class="control-label">广告宣传图</label>
				<img alt="广告宣传图" src="<?php echo $spproject->pic_url;?>"> <input
					type="file" name="pic_url" id="inputpic_url" required />
				<p class="help-block">尺寸 400 X 400</p>
			</div>
			<div class="form-group">
				<label name="moban_url" for="inputmoban_url" class="control-label">海报地址</label>
				<input type="url" name="moban_url" class="form-control"
					id="inputmoban_url" placeholder="海报地址" value="" required>
			</div>
			<div class="form-group">
				<label name="m_about1" for="inputm_about1" class="control-label">项目简介－移动端</label>
				<textarea name="m_about1" rows="5" class="form-control"
					id="inputm_about1" placeholder="项目简介－移动端"></textarea>
			</div>
			<div class="form-group">
				<label name="m_about2" for="inputm_about2" class="control-label">招商政策－移动端</label>
				<textarea name="m_about2" rows="5" class="form-control"
					id="inputm_about2" placeholder="招商政策－移动端"></textarea>
			</div>
			<div class="form-group">
				<label name="m_about3" for="inputm_about3" class="control-label">盈利分析－移动端</label>
				<textarea name="m_about3" rows="5" class="form-control"
					id="inputm_about3" placeholder="盈利分析－移动端"></textarea>
			</div>
			<div class="form-group">
				<label name="phone_or_400" for="inputphone_or_400"
					class="control-label">招商电话</label> <input type="text"
					name="phone_or_400" class="form-control" id="inputphone_or_400"
					placeholder="招商电话" value="">
			</div>
			<div class="form-group">
				<label name="db_shangqiao_code" for="inputdb_shangqiao_code"
					class="control-label">百度商桥代码</label>
				<textarea name="db_shangqiao_code" rows="5" class="form-control"
					id="inputdb_shangqiao_code" placeholder="百度商桥代码"></textarea>
			</div>
			<button type="sumbit" class="btn btn-default">提交</button>
		</form>
		<a href="javascript:history.go(-1);">返回</a>
	</div>
</body>
</html>
