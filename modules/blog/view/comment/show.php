<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>展示comment</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>展示comment</h2>
<p><strong>博客id: </strong><?php echo $comment->blog_id;?></p>
<p><strong>评论内容: </strong><?php echo $comment->content;?></p>
<p><strong>评论时间: </strong><?php echo $comment->addtime;?></p>
<p><strong>评论者ip: </strong><?php echo $comment->ip;?></p>
<a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
