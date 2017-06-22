<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>修改vote</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>修改vote</h2>
<form method='post' enctype="multipart/form-data" action="/vote/voteServer/edit?key=4c35bVgFUB1YIVVMBA1ZUBQwMWFcMClFVCQYNAlBWG1BVDggI">
<div class="form-group">
<label name="qiye_id" for="inputqiye_id" class="control-label">企业(支队)ID</label>
<input type="text" name="qiye_id" class="form-control" id="inputqiye_id" placeholder="企业(支队)ID" value="<?php echo $vote->qiye_id;?>" required>
</div>
<div class="form-group">
<label name="type" for="inputtype" class="control-label">投票类型， 1 文字投票，2图文投票，3视频投票</label>
<input type="text" name="type" class="form-control" id="inputtype" placeholder="投票类型， 1 文字投票，2图文投票，3视频投票" value="<?php echo $vote->type;?>" required>
</div>
<div class="form-group">
<label name="title" for="inputtitle" class="control-label">投票标题</label>
<input type="text" name="title" class="form-control" id="inputtitle" placeholder="投票标题" value="<?php echo $vote->title;?>" required>
</div>
<div class="form-group">
<label name="title_pic" for="inputtitle_pic" class="control-label">投票配图</label>
<img alt="投票配图" src="<?php echo $vote->title_pic;?>">
<input type="file" name="title_pic" id="inputtitle_pic" />
<p class="help-block">头像尺寸 200 X 200</p></div>
<div class="form-group">
<label name="start_time" for="inputstart_time" class="control-label">开始时间</label>
<input type="text" name="start_time" class="form-control" id="inputstart_time" placeholder="开始时间" value="<?php echo $vote->start_time;?>" required>
</div>
<div class="form-group">
<label name="end_time" for="inputend_time" class="control-label">结束时间</label>
<input type="text" name="end_time" class="form-control" id="inputend_time" placeholder="结束时间" value="<?php echo $vote->end_time;?>" required>
</div>
<div class="form-group">
<label name="option_setting" for="inputoption_setting" class="control-label">选项设置: 1 单选，2 最多选两项，3 最多选三项， 4 不限制</label>
<input type="text" name="option_setting" class="form-control" id="inputoption_setting" placeholder="选项设置: 1 单选，2 最多选两项，3 最多选三项， 4 不限制" value="<?php echo $vote->option_setting;?>" required>
</div>
<div class="form-group">
<label name="rate" for="inputrate" class="control-label">投票频率:1 每人一票，2每天一票</label>
<input type="text" name="rate" class="form-control" id="inputrate" placeholder="投票频率:1 每人一票，2每天一票" value="<?php echo $vote->rate;?>" required>
</div>
    <input type="hidden" name="vote_id" value="<?php echo $vote->id;?>" />
<button type="sumbit" class="btn btn-default">提交</button>
</form>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
