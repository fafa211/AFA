<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>新增blog</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
<h2>新增blog</h2>
<form method='post' enctype="multipart/form-data">
<div class="form-group">
<label name="title" for="inputtitle" class="control-label">标题</label>
<input type="text" name="title" class="form-control" id="inputtitle" placeholder="标题" value="" required>
</div>
<div class="form-group">
<label name="content" for="inputcontent" class="control-label">内容</label>
<textarea name="content" rows="5" class="form-control" id="inputcontent" placeholder="内容" required></textarea>
</div>
<div class="form-group">
<label name="author" for="inputauthor" class="control-label">作者</label>
<input type="text" name="author" class="form-control" id="inputauthor" placeholder="作者" value="">
</div>
<div class="form-group">
<label name="ctime" for="inputctime" class="control-label">发布时间</label>
<input type="datetime" name="ctime" class="form-control" id="inputctime" placeholder="发布时间" value="" required>
</div>
<div class="form-group">
<label name="email" for="inputemail" class="control-label">Email</label>
<input type="email" name="email" class="form-control" id="inputemail" placeholder="Email" value="" required>
</div>
<div class="form-group">
<label for="inputsex_1" class="control-label">请选择性别</label>

<div class="radio">
<label>
<input type="radio" name="sex" id="inputsex_1" value="1"  required> 十足的男性
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="sex" id="inputsex_2" value="2"  required> 十足的女性
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="sex" id="inputsex_3" value="3"  required> 有时呈男性，有时呈女性
</label>
</div>
<div class="radio">
<label>
<input type="radio" name="sex" id="inputsex_4" value="4"  required> 既不呈男性，也不呈女性
</label>
</div>
</div>
<div class="form-group">
<label for="inputlove_1" class="control-label">请选择爱好</label>

<div class="checkbox">
<label>
<input type="checkbox" name="love[]" id="inputlove_1" value="1"> 无尽的编程
</label>
</div>
<div class="checkbox">
<label>
<input type="checkbox" name="love[]" id="inputlove_2" value="2"> 无尽的游玩
</label>
</div>
<div class="checkbox">
<label>
<input type="checkbox" name="love[]" id="inputlove_3" value="3"> 无尽的睡觉
</label>
</div>
<div class="checkbox">
<label>
<input type="checkbox" name="love[]" id="inputlove_4" value="4"> 无尽的发呆
</label>
</div>
<div class="checkbox">
<label>
<input type="checkbox" name="love[]" id="inputlove_5" value="5"> 无尽的购物
</label>
</div>
</div>
<div class="form-group">
<label for="inputsalary" class="control-label">请选择薪水</label>
<select name="salary" id="inputsalary" class="form-control" required>
<option value="1" >月薪1000以下</option>
<option value="2" >月薪1000 ~ 10000</option>
<option value="3" >月薪10000以上</option>
</select></div>
<div class="form-group">
<label name="headpic" for="inputheadpic" class="control-label">头像</label>
<input type="file" name="headpic" id="inputheadpic" required />
<p class="help-block">头像尺寸 200 X 200</p></div>
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
