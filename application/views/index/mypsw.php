<div class="container">
  <div class="row form-padding">
    <ul id="myTab" class="nav nav-pills">
		    <li><a href="./index.php?route=index/avatar">修改头像</a></li>
		    <li><a href="./index.php?route=index/mypub">我的主题</a></li>
		    <li><a href="./index.php?route=index/myrep">我的回答</a></li>
		    <li><a href="./index.php?route=msg/showmsg">我的消息</a></li>
		    <li class="active"><a href="./index.php?route=index/mypsw">修改密码</a></li>
		    <li><a href="./index.php?route=index/whoami">自我介绍</a></li>
		</ul>
		<div id="myTabContent" class="tab-content form-padding">
		    <div class="tab-pane fade in active">
<link rel="stylesheet" href="static/awesome/font-awesome.min.css">
<link rel="stylesheet" href="static/awesome/build.css">
<script src="static/validation/jquery.validate.min.js"></script>
<form id="pswform">
  <div class="form-group">
    <label for="oldpsw">旧密码</label>
    <input type="password" class="form-control" name="oldpsw" id="oldpsw" placeholder="输入原密码">
  </div>
  <div class="form-group">
    <label for="newpsw">新密码</label>
    <input type="password" class="form-control" name="newpsw" id="newpsw" placeholder="输入新密码">
  </div>
  <button type="submit" class="btn btn-success">更新</button>
</form>
<script>
$("#pswform").validate({
	rules: {
				newpsw: {
					required:true,
					minlength: "6"
				}
			},
	messages: {
				newpsw: {
					required:'新密码必填',
					minlength: "长度至少6个字符"
				}
			},
  submitHandler: function(form) {
  	$(form).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=index/domypsw",{oldpsw:$('#oldpsw').val(),newpsw:$('#newpsw').val()},function(dat){
  		if(dat){
  			parent.layer.open({
				  title: '成功提示'
				  ,content: '密码更新成功！'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.location.href='./index.php?route=index/mypsw';
				  }
				});  
  		}else{
  		    parent.layer.open({
				  title: '错误提示'
				  ,content: '操作错误，更新失败！'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(rel){
				    parent.layer.close(rel);
		  			$(form).find(':button[type=submit]').prop('disabled', false);
				  }
				});  
  		}
  	})
	  return false; 
	}
});
</script>
			</div>
		</div>
  </div>
</div>