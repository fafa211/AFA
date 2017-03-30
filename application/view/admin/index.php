<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>管理员登录</title>
<link href="/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/static/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<script src="/static/js/libs/jquery.min.js"></script>
<script src="/static/bootstrap/js/bootstrap.js"></script>
</head>

<frameset rows="50,*" cols="*" frameborder="no" border="0" framespacing="0">
    <frame src="<?php echo input::uri("base"); ?>admin/head" name="topFrame" scrolling="no" noresize="noresize" id="topFrame" title="topFrame" />
    <frameset rows="*" cols="200,*" framespacing="0" frameborder="no" border="0">
        <frame  src="<?php echo input::uri("base"); ?>admin/left" name="leftFrame" scrolling="yes" noresize="noresize" style="overflow-x:hidden;overflow-y:auto;" id="leftFrame" title="leftFrame" />
        <frame src="<?php echo input::uri("base"); ?>admin/home" name="mainFrame" id="mainFrame" title="mainFrame" style="overflow:auto;" />
    </frameset>
</frameset>

