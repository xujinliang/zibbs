<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>转移主题</title>
<script src="static/js/jquery.js"></script>
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="static/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="static/css/main.css">
<script src="static/layer/layer.js"></script>
</head>
<body>
<form id="postform" class="form-padding">
  <div class="form-group">
    <label class="control-label">隶属标签</label>
      <select name="tagid" id="tagid" class="form-control">
      	<?php
      	if(!empty($showtags)){
      		foreach($showtags as $tag){	?>
      			<option value="<?php echo $tag['id'];?>" <?php if($tag['id']==$tagid){echo ' selected';} ?>><?php echo $tag['name'];?></option>
      	<?php	}
      	}?>
      </select>
  </div>
  <div class="form-group">
  	<input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>">
      <button type="submit" class="btn btn-info">更新</button>
  </div>
</form>
<script>
$("#postform").submit(function(){
	$(this).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=admin/domovepost",{tagid:$('#tagid').val(),pid:$('#pid').val()},function(dat){
  		if(dat){
  			parent.layer.open({
				  title: '成功提示'
				  ,content: '更新成功！'
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
});
</script>
</body>
</html>