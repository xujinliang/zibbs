<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>编辑标签</title>
<script src="static/js/jquery.js"></script>
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="static/css/main.css">
<script src="static/layer/layer.js"></script>
<script src="static/validation/jquery.validate.min.js"></script>
</head>
<body>
<form id="tagform" class="form-padding">
  <div class="form-group">
    <label class="control-label">标签名</label>
      <input type="text" name="tagname" id="tagname" value="<?php echo $rs['name'];?>" placeholder="请输入标签名" autocomplete="off" class="form-control required">
  </div>
  <div class="form-group">
    <label class="control-label">描述</label>
      <textarea name="tagdesc" id="tagdesc" placeholder="请输入标签描述" autocomplete="off" class="form-control required"><?php echo $rs['description'];?></textarea>
  </div>
  <div class="form-group">
    <label class="control-label">序号</label>
      <input type="text" name="tagsort" id="tagsort" value="<?php echo $rs['sort'];?>" placeholder="请输入序号（数字）" autocomplete="off" class="form-control">
  </div>
  <div class="form-group">
  	 <input type="hidden" value="<?php echo $rs['id'];?>" id="tagid">
      <button type="submit" class="btn btn-info">更新</button>
      <button type="reset" class="btn">重置</button>
  </div>
</form>
<script>
$("#tagform").validate({
	rules: {
				tagname: "required",
				tagdesc: "required",
			},
	messages: {
				tagname: "标签名必填",
				tagdesc: "标签描述必填",
			},
  submitHandler: function(form) {
  	$(form).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=admin/doedittag",{tagname:$('#tagname').val(),tagdesc:$('#tagdesc').val(),tagsort:$('#tagsort').val(),tagid:$('#tagid').val()},function(dat){
  		if(dat){
  			parent.layer.open({
				  title: '成功提示'
				  ,content: '标签更新成功！'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.parent.location.reload();
				  }
				});  
  		}else{
  			parent.layer.open({
				  title: '错误提示'
				  ,content: '操作错误，更新失败！'
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