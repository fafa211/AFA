<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示blog</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示blog</h2>
<p><strong>标题: </strong><?php echo $blog->title;?></p>
<p><strong>内容: </strong><?php echo $blog->content;?></p>
<p><strong>作者: </strong><?php echo $blog->author;?></p>
<p><strong>发布时间: </strong><?php echo $blog->ctime;?></p>
<p><strong>Email: </strong><?php echo $blog->email;?></p>
<p><strong>性别: </strong><?php echo F::findInArray($blog->sex, $sex_arr);?></p>
<p><strong>爱好: </strong><?php echo F::findInArray($blog->love, $love_arr);?></p>
<p><strong>薪水: </strong><?php echo F::findInArray($blog->salary, $salary_arr);?></p>
<p><strong>头像: </strong><?php echo $blog->headpic;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
