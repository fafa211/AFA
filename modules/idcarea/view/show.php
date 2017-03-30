<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>展示idcarea</title>
    <link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <script src="/static/js/libs/jquery.min.js"></script>
    <script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
    <h2>展示idcarea</h2>
    <p><strong>区域地址: </strong><?php echo $idcarea->address; ?></p>
    <p><strong>级别: </strong><?php echo F::findInArray($idcarea->the_level, $the_level_arr); ?></p>
    <p><strong>区域名称: </strong><?php echo $idcarea->name; ?></p>
    <a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
