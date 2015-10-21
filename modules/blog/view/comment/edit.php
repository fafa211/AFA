<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>修改comment</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>修改comment</h2>
<form method='post' >
<div class="form-group">
<label name="blog_id" for="inputblog_id" class="control-label">博客id</label>
<input type="number" name="blog_id" class="form-control" id="inputblog_id" placeholder="博客id" value="<?php echo $comment->blog_id;?>" required>
</div>
<div class="form-group">
<label name="content" for="inputcontent" class="control-label">评论内容</label>
<textarea name="content" rows="5" class="form-control" id="inputcontent" placeholder="评论内容" required><?php echo $comment->content;?></textarea>
</div>
<button type="sumbit" class="btn btn-default">提交</button>
</form>
<script type="text/javascript">
        $(':submit').click(function(){
            $('.form-group').each(function(){
                if($(':checkbox', this).length){
                    if($(':checkbox:checked', this).length<1){
                        $(':checkbox', this).get(0).setCustomValidity("请选择至少一项!");
                    }else{
                        $(':checkbox',this).each(function(){this.setCustomValidity("");});
                    }
                }
                var _this = this;
                $(':checkbox', this).click(function(){
                    if(this.checked){
                        $(':checkbox', _this).each(function(){this.setCustomValidity("");});
                    }
                });
            });
        });
        </script><a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
