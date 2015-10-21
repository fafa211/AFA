<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Code Maker</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">

</script>
</head>
<body>
<div class="container">
<h2>模块代码生成器 </h2>
<form method="post" >
  <div class="form-group">
    <label for="exampleInputEmail1">代码生成地址</label>
    <p class="lead">请点击 <a href="<?php echo input::uri('base').'codemaker/maker';?>" target="codemaker">模块代码生成</a> 执行生成.<br />
    模块代码生成地址：<code><?php echo input::uri('base').'codemaker/maker';?></code></p>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">注意事项</label>
    <p>
        <strong>请提前做好相应的设置：请确保不存在要生成的模块，否则会被覆盖。</strong><br /><br />
        <code>$module = 'blog';//模型名称<br />
        $table = 'blog';//表名<br />
        $prikey = 'id';//主键名<br />
        $fileds = array(<br />
            array(<br />
                'name' => 'title',//字段名称<br />
                'cnname' => '标题',//字段中文名称(描述)<br />
                'type' => 'text',//字段类型<br />
                'content_type' => 'common',//字段内容类型<br />
                'is_empty'=>false,//是否允许为空<br />
                'is_edit'=>true, //是否可编辑<br />
                'list_show'=>true,//列表显示时是否显示<br />
                'default_value' => ''//默认值<br />
            ),<br />
            .<br />
            .<br />
            .<br />
         </code>
     </p>
  </div>
</form>
</div>


</body>
</html>
