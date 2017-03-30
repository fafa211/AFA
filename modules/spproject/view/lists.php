<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>列表管理 spproject</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
	<div class="container">
		<h2>项目管理</h2>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>项目名称</th>
						<th>广告宣传图</th>
						<th>招商电话</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
<?php foreach ($lists as $arr):?>
<tr>
<?php foreach ($arr as $k=>$v):?>
<?php

        
if (in_array($k, $list_fields_arr)) {
            $param = $k . '_arr';
            if (isset($$param) && is_array($$param)) {
                echo '<td>' . F::findInArray($v, $$param) . '</td>';
            } else {
                switch ($k){
                    case 'name':
                        echo '<td><a href="show/' .$arr['id'] . '" target="_blank">' .$v . '</td>';
                        break;
                    case 'pic_url':
                        echo '<td><img src="' .$v . '" width="200" onclick="window.open(\''.$v.'\')"></td>';
                        break;
                    case '':
                        break;
                    case '':
                        break;
                    default:
                        echo '<td>' . $v . '</td>';
                        break;
                }
            }
        }
        ?><?php
    
endforeach
    ;
    ?>
<td><a href="show/<?php echo $arr['id'];?>">查看</a> <a
							href="edit/<?php echo $arr['id'];?>">修改</a></td>
					</tr>
<?php endforeach;?>
</tbody>
			</table>
		</div>
		<a href="add" class="col-md-1">新增</a> <a
			href="javascript:history.go(-1);">返回</a>
	</div>
</body>
</html>
