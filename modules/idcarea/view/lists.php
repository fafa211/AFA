<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>列表管理 idcarea</title>
    <link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <script src="/static/js/libs/jquery.min.js"></script>
    <script src="/static/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<div class="container">
    <h2>列表管理 idcarea</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>区域地址</th>
                <th>级别</th>
                <th>区域名称</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lists as $k => $arr): ?>
                <tr>
                    <?php foreach ($arr as $k => $v): ?>
                        <?php if (in_array($k, $list_fields_arr)) {
                            $param = $k . '_arr';
                            if (isset($$param) && is_array($$param)) {
                                echo '<td>' . F::findInArray($v, $$param) . '</td>';
                            } else {
                                echo '<td>' . $v . '</td>';
                            }
                        }
                        ?><?php endforeach; ?>
                    <td><a href="show/<?php echo $arr['id']; ?>">查看</a>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
