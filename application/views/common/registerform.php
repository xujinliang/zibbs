<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>注册</title>
<script src="static/js/jquery.js"></script>
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="static/css/main.css">
<script src="static/layer/layer.js"></script>
<script src="static/validation/jquery.validate.min.js"></script>
</head>
<body>
<form id="registerform" class="form-padding">
  <div class="form-group">
    <label class="control-label">用户名</label>
      <input type="text" name="username" id="username" placeholder="请输入用户名" autocomplete="off" class="form-control specialCharValidate required">
  </div>
  <div class="form-group">
    <label class="control-label">邮箱</label>
      <input type="email" name="email" id="email" placeholder="请输入邮箱" autocomplete="off" class="form-control required">
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

jQuery.validator.addMethod("specialCharValidate", 
	function(value, element) {
		var pattern = new RegExp("^[\u4E00-\u9FA5a-zA-Z0-9_]+$"); 
		return this.optional(element) || (pattern.test(value));
	}, '只允许输入中文、字母、数字、下划线'); 

$("#registerform").validate({
	rules: {
				username: {
					required:true,
					rangelength:[3,12],
					specialCharValidate:true
				},
				email: "required",
				password: "required"
			},
	messages: {
				username: {
					required:'用户名必填',
					rangelength:'用户名长度在3~12位'
				},
				email: "邮箱必填",
				password: "密码必填"
			},
  submitHandler: function(form) {
  	var loadding = layer.load(1, {
	  	shade: [0.1,'#fff']
		});
		$(form).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=common/doregister",{username:$('#username').val(),email:$('#email').val(),password:$('#password').val()},function(dat){
  		$("#registerform").hide();
  		layer.close(loadding);
  		if(dat == '1'){
  			parent.layer.open({
				  title: '成功提示'
				  ,content: '恭喜！注册成功，请至邮箱激活！'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.parent.location.reload();
				  }
				});  
  		}else if(dat == '2'){
  			parent.layer.open({
				  title: '错误提示'
				  ,content: '系统配置邮箱SMTP有误'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(){
				    parent.layer.closeAll();
				  }
				});  
  		}else if(dat == '3'){
  			parent.layer.open({
				  title: '错误提示'
				  ,content: '主机不支持Mail函数'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(){
				    parent.layer.closeAll();
				  }
				});  
  		}else{
  			parent.layer.open({
				  title: '错误提示'
				  ,content: '1、用户名或邮箱已被占用<br>2、后台配置邮件SMTP有误<br>3、非法输入，请检查输入格式'
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