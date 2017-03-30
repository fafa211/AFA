<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>修改idcarea</title>
    <link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <script src="/static/js/libs/jquery.min.js"></script>
    <script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
    <h2>修改idcarea</h2>
    <form method='post'>
        <div class="form-group">
            <label name="address" for="inputaddress" class="control-label">区域地址</label>
            <input type="text" name="address" class="form-control" id="inputaddress" placeholder="区域地址"
                   value="<?php echo $idcarea->address; ?>" required>
        </div>
        <div class="form-group">
            <label name="name" for="inputname" class="control-label">区域名称</label>
            <input type="text" name="name" class="form-control" id="inputname" placeholder="区域名称"
                   value="<?php echo $idcarea->name; ?>" required>
        </div>
        <button type="sumbit" class="btn btn-default">提交</button>
    </form>
    <a href="javascript:history.go(-1);">返回</a>
</div>
</body>
</html>
