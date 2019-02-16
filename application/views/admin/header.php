<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="./favicon.ico">
<title>后台管理</title>
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="static/awesome/font-awesome.min.css" rel="stylesheet">
<link href="static/bootstrap/css/dashboard.css" rel="stylesheet">
<script src="static/js/jquery.js"></script>
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<script src="static/layer/layer.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top my-navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./index.php?route=admin/index">梓论坛控制面板</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
    	<ul class="nav navbar-nav visible-xs">
      	<li><a href="./index.php?route=admin/tags"><i class="fa fa-hashtag"></i> 标签</a></li>
        <li><a href="./index.php?route=admin/users"><i class="fa fa-user"></i> 用户</a></li>
        <li><a href="./index.php?route=admin/posts"><i class="fa fa-file"></i> 主题</a></li>
        <li><a href="./index.php?route=admin/replies"><i class="fa fa-reply"></i> 回答</a></li>
        <li><a href="./index.php?route=admin/clean"><i class="fa fa-send"></i> 消息清理</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a target="_blank" href="<?php echo $siteurl;?>">访问前台</a></li>
        <li><a href="./index.php?route=admin/setting">设置</a></li>
        <li><a href="./index.php?route=admin/logout">退出</a></li>
      </ul>
    </div>
  </div>
</nav>