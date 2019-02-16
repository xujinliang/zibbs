<div class="container">
  <div class="row form-padding">
    <ul id="myTab" class="nav nav-pills">
		    <li><a href="./index.php?route=index/mycenter">修改头像</a></li>
		    <li><a href="./index.php?route=index/mypub">我的主题</a></li>
		    <li><a href="./index.php?route=index/myrep">我的回答</a></li>
		    <li><a href="./index.php?route=msg/showmsg">我的消息</a></li>
		    <li><a href="./index.php?route=index/mypsw">修改密码</a></li>
		    <li class="active"><a href="./index.php?route=index/whoami">自我介绍</a></li>
		</ul>
		<div id="myTabContent" class="tab-content form-padding">
		    <div class="tab-pane fade in active">
<link rel="stylesheet" href="static/awesome/font-awesome.min.css">
<link rel="stylesheet" href="static/awesome/build.css">
<form id="whoform">
  <div class="form-group">
    <label for="oldpsw">自我介绍</label>
    <textarea class="form-control" name="whoamidesc" id="whoamidesc" placeholder="输入自我介绍，最大50个字符"><?php echo $whoamidesc;?></textarea>
  </div>
  <button type="submit" class="btn btn-success">更新</button>
</form>
<script>
$("#whoform").submit(function() {
	var _this = $(this);
	_this.find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=index/dowhoami",{whoamidesc:$('#whoamidesc').val()},function(dat){
  		if(dat){
  			parent.layer.open({
				  title: '成功提示'
				  ,content: '更新成功！'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.location.href='./index.php?route=index/whoami';
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
				    _this.find(':button[type=submit]').prop('disabled', false);
				  }
				});
  		}
  	})
	  return false; 
});
</script>
			</div>
		</div>
  </div>
</div>