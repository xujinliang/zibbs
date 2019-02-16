<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>登录</title>
<script src="static/js/jquery.js"></script>
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="static/css/main.css">
<script src="static/layer/layer.js"></script>
<script src="static/validation/jquery.validate.min.js"></script>
</head>
<body>
<form id="loginform" class="form-padding">
  <div class="form-group">
    <label class="control-label">帐户</label>
      <input type="text" name="account" id="account" placeholder="请输入用户名或邮箱" autocomplete="off" class="form-control required">
  </div>
  <div class="form-group">
    <label class="control-label">密码</label>
      <input type="password" name="password" id="password" placeholder="请输入密码" autocomplete="off" class="form-control required">
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-info">立即提交</button>
      <button type="reset" class="btn">重置</button>
  </div>
</form>
<script>
$("#loginform").validate({
	rules: {
				account: "required",
				password: "required"
			},
	messages: {
				account: "帐户必填",
				password: "密码必填"
			},
  submitHandler: function(form) {
  	$(form).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=common/dologin",{account:$('#account').val(),password:$('#password').val()},function(dat){
  		$("#loginform").hide();
  		if(dat){
  			parent.layer.open({
				  title: '成功提示'
				  ,content: '恭喜！您已登陆成功！'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.parent.location.href="./";
				  }
				});  
  		}else{
  			parent.layer.open({
				  title: '错误提示'
				  ,content: '遗憾！登录信息有误，请重试！'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(){
				    parent.layer.closeAll();
				  }
				});  
  		}
  	})
	  return false; 
	}
});
</script>
</body>
</html>