<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示vote</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示vote</h2>
<p><strong>: </strong><?php echo $vote->id;?></p>
<p><strong>所属帐号id: </strong><?php echo $vote->account_id;?></p>
<p><strong>创建人ID: </strong><?php echo $vote->uid;?></p>
<p><strong>企业(支队)ID: </strong><?php echo $vote->qiye_id;?></p>
<p><strong>投票类型， 1 文字投票，2图文投票，3视频投票: </strong><?php echo $vote->type;?></p>
<p><strong>投票标题: </strong><?php echo $vote->title;?></p>
<p><strong>投票配图: </strong><?php echo $vote->title_pic;?></p>
<p><strong>投票说明: </strong><?php echo $vote->about;?></p>
<p><strong>开始时间: </strong><?php echo $vote->start_time;?></p>
<p><strong>结束时间: </strong><?php echo $vote->end_time;?></p>
<p><strong>选项设置: 1 单选，2 最多选两项，3 最多选三项， 4 不限制: </strong><?php echo $vote->option_setting;?></p>
<p><strong>投票频率:1 每人一票，2每天一票: </strong><?php echo $vote->rate;?></p>
<p><strong>创建时间: </strong><?php echo $vote->add_time;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
