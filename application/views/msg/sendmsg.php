<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>短消息</title>
<script src="static/js/jquery.js"></script>
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="static/css/main.css">
<script src="static/layer/layer.js"></script>
<script src="static/validation/jquery.validate.min.js"></script>
</head>
<body>
<form id="msgform" class="form-padding">
	<div class="form-group">
		<input type="text" name="title" id="title" placeholder="输入消息标题" autocomplete="off" class="form-control required" style="background-color: hsla(0,0%,71%,.1);">
	</div>
  <div class="form-group">
    <textarea name="msgcontent" id="msgcontent" placeholder="输入您要发送的消息内容" autocomplete="off" class="form-control required" style="background-color: hsla(0,0%,71%,.1);"></textarea>
  </div>
  <div class="form-group">
  		<input type="hidden" name="lid" id="lid" value="<?php echo $lid;?>">
  		<input type="hidden" name="set" id="set" value="<?php echo $set;?>">
      <button type="submit" class="btn btn-info">立即提交</button>
      <button type="reset" class="btn">重置</button>
  </div>
</form>
<script>
$("#msgform").validate({
	rules: {
				title: "required",
				msgcontent: "required",
			},
	messages: {
				title: "标题必填",
				msgcontent: "内容必填",
			},
  submitHandler: function(form) {
  	$(form).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=msg/dosendmsg",{lid:$('#lid').val(),set:$('#set').val(),title:$('#title').val(),msgcontent:$('#msgcontent').val()},function(dat){
  		$("#msgform").hide();
  		if(dat){
  			 parent.layer.open({
				  title: '成功提示'
				  ,content: '恭喜！消息发送成功！'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				  	parent.layer.closeAll();
				    //window.parent.location.reload();
				  }
				});  
  		}else{
  			 parent.layer.open({
				  title: '错误提示'
				  ,content: '发送失败，可能原因：<br>1、用户未登录!<br>2、不能给自己发送短消息！'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(){
				  	parent.layer.closeAll();
				    //window.parent.location.reload();
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