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
<link href="static/bootstrap/css/dashboard.css" rel="stylesheet">
<script src="static/js/jquery.js"></script>
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<script src="static/layer/layer.js"></script>
</head>
<body>
<div class="container loginctn">
	<div class="col-sm-4"></div>
  <div class="col-sm-4 form-box">
  	<div class="form-top">
  		<div class="form-top-left">
  			<h3>梓论坛管理面板</h3>
      		<p>在下方输入管理账号和密码</p>
  		</div>
  		<div class="form-top-right">
  			<i class="fa fa-key"></i>
  		</div>
      </div>
      <div class="form-bottom">
	      <form id="loginform">
	      	<div class="form-group">
	      		<label class="sr-only" for="form-username">帐户</label>
	          	<input type="text" name="username" placeholder="管理帐户" class="form-username form-control" id="username">
	          </div>
	          <div class="form-group">
	          	<label class="sr-only" for="form-password">密码</label>
	          	<input type="password" name="password" placeholder="管理密码" class="form-password form-control" id="password">
	          </div>
	          <button type="submit" class="btn">登录</button>
	      </form>
	    </div>
  </div>
  <div class="col-sm-4"></div>
</div>
<style>
body{background-color: #f8f8f8;}
.btn{background-color: #5bc0de;border-color: #46b8da;color:#fff}
.btn:hover {color: #fff;background-color: #31b0d5;border-color: #269abc;}
.form-box{box-shadow: 1px 1px 50px rgba(0,0,0,.3);}
</style>
<script>
$("#loginform").submit(function(){
var _this = $(this);
_this.find(':button[type=submit]').prop('disabled', true);
$.post("./index.php?route=admin/dologin",{username:$('#username').val(),password:$('#password').val()},function(dat){
	if(dat){
		layer.open({
		  title: '成功提示'
		  ,content: '恭喜！登录成功'
		  ,icon: 6
		  ,closeBtn: 0
		  ,yes: function(){
			    window.location.href='./index.php?route=admin/index';
		  }
		});
	}else{
		layer.open({
		  title: '错误提示'
		  ,content: '遗憾！登录失败！'
		  ,icon: 5
		  ,closeBtn: 0
		  ,yes: function(rel){
		  	layer.close(rel);
		  	_this.find(':button[type=submit]').prop('disabled', false);
		  }
		});
	}
})
return false;
})
</script>
</body>
</html>