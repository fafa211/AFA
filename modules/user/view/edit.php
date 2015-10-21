<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>修改user</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>修改user</h2>
<form method='post' >
<div class="form-group">
<label name="account" for="inputaccount" class="control-label">账号</label>
<input type="text" name="account" class="form-control" id="inputaccount" placeholder="账号" value="<?php echo $user->account;?>" required>
</div>
<div class="form-group">
<label name="passwd" for="inputpasswd" class="control-label">密码</label>
<input type="password" name="passwd" class="form-control" id="inputpasswd" placeholder="密码" value="<?php echo $user->passwd;?>" required>
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
