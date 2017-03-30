<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示spproject</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示spproject</h2>
<p><strong>项目名称: </strong><?php echo $spproject->name;?></p>
<p><strong>广告宣传图: </strong><img alt="" src="<?php echo $spproject->pic_url;?>"></p>
<p><strong>海报地址: </strong><?php echo $spproject->moban_url;?></p>
<p><strong>项目简介－移动端: </strong><?php echo $spproject->m_about1;?></p>
<p><strong>招商政策－移动端: </strong><?php echo $spproject->m_about2;?></p>
<p><strong>盈利分析－移动端: </strong><?php echo $spproject->m_about3;?></p>
<p><strong>招商电话: </strong><?php echo $spproject->phone_or_400;?></p>
<p><strong>百度商桥代码: </strong><?php echo htmlspecialchars($spproject->db_shangqiao_code);?></p>
<p><strong>创建时间: </strong><?php echo $spproject->create_time;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
