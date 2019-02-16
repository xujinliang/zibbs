<div class="container">
  <div class="row">
      <div class="col-sm-3 hidden-xs">
	      <!-- left -->
	      <h3><i class="fa fa-navicon"></i> 菜单管理</h3>
	      <hr>
	      <ul class="nav nav-stacked">
	      	<li><a href="./index.php?route=admin/tags"><i class="fa fa-hashtag"></i> 标签</a></li>
	        <li><a href="./index.php?route=admin/users"><i class="fa fa-user"></i> 用户</a></li>
	        <li><a href="./index.php?route=admin/posts"><i class="fa fa-file"></i> 主题</a></li>
	        <li><a href="./index.php?route=admin/replies"><i class="fa fa-reply"></i> 回答</a></li>
	        <li><a href="./index.php?route=admin/clean"><i class="fa fa-send"></i> 消息清理</a></li>
	      </ul>
	      <hr>
    </div>
    <div class="col-sm-9">
     	<h3>设置</h3>
     	 <hr>
     	 <form id="settingform">
		  <div class="form-group">
		    <label for="siteurl">网站地址</label>
		    <input type="text" class="form-control" id="siteurl" placeholder="网站地址" value="<?php echo $settingarr['siteurl'];?>">
		  </div>
		  <div class="form-group">
		    <label for="sitetitle">站点名称</label>
		    <input type="text" class="form-control" id="sitetitle" placeholder="站点名称" value="<?php echo $settingarr['sitetitle'];?>">
		  </div>
		  <div class="form-group">
		    <label for="sitekeywords">站点关键字，用于SEO</label>
		    <input type="text" class="form-control" id="sitekeywords" placeholder="站点关键字" value="<?php echo $settingarr['sitekeywords'];?>">
		  </div>
		  <div class="form-group">
		    <label for="sitedescription">站点描述，用于SEO</label>
		    <textarea class="form-control" id="sitedescription" placeholder="站点描述"><?php echo $settingarr['sitedescription'];?></textarea>
		  </div>
		  <div class="form-group">
		    <label for="sitetitle">注册密钥 <i> (用户自定义字符串，为了使用户密码加密方式更安全)</i></label>
		    <input type="text" class="form-control" id="sitekey" placeholder="注册密钥" value="<?php echo $sitekey;?>">
		  </div>
		  <div class="form-group">
		    <label for="smtphost">SMTP服务器 <i> (如果不填写，默认使用Mail函数发信)</i></label>
		    <input type="text" class="form-control" id="smtphost" placeholder="SMTP服务器" value="<?php echo $settingarr['smtphost'];?>">
		  </div>
		  <div class="form-group">
		    <label for="smtpuser">SMTP用户名 <i> (如果不填写，默认使用Mail函数发信)</i></label>
		    <input type="text" class="form-control" id="smtpuser" placeholder="SMTP用户名" value="<?php echo $settingarr['smtpuser'];?>">
		  </div>
		  <div class="form-group">
		    <label for="smtppsw">SMTP密码/授权码 <i> (如果不填写，默认使用Mail函数发信)</i></label>
		    <input type="text" class="form-control" id="smtppsw" placeholder="SMTP密码/授权码" value="<?php echo $settingarr['smtppsw'];?>">
		  </div>
		  <div class="form-group">
		    <label for="smtppsw">发件人邮箱</label>
		    <input type="text" class="form-control" id="smtpemail" placeholder="发件人" value="<?php echo $settingarr['smtpemail'];?>">
		  </div>
		  <div class="form-group">
		    <label for="smtppsw">邮件主题</label>
		    <input type="text" class="form-control" id="smtpsubject" placeholder="邮件主题" value="<?php echo $settingarr['smtpsubject'];?>">
		  </div>
		  <div class="form-group">
		    <label for="smtppsw">邮件内容</label>
		    <textarea class="form-control" id="smtpcontent" rows="5" placeholder="邮件内容"><?php echo $settingarr['smtpcontent'];?></textarea>
		  </div>
		  <div class="form-group">
		    <label for="smtppsw">主页显示本站简介，支持HTML语法</label>
		    <textarea class="form-control" id="bbsmeta" rows="5" placeholder="主页显示本站简介"><?php echo $settingarr['bbsmeta'];?></textarea>
		  </div>
		  <div class="form-group">
		    <label for="smtppsw">友情链接，格式为 "链接名称|链接地址"，以 "|" 隔开，多个链接换行输入</label>
		    <textarea class="form-control" id="bbslink" rows="5" placeholder="友情链接"><?php echo $settingarr['bbslink'];?></textarea>
		  </div>
		  <button type="submit" class="btn btn-success">更新</button>
		</form>
     </div>
  </div>
</div>
<script>
$("#settingform").submit(function(){
	var _this = $(this);
	_this.find(':button[type=submit]').prop('disabled', true);
	$.post("./index.php?route=admin/dosetting",{
		siteurl:$('#siteurl').val(),
		sitetitle:$('#sitetitle').val(),
		sitekeywords:$('#sitekeywords').val(),
		sitedescription:$('#sitedescription').val(),
		smtphost:$('#smtphost').val(),
		smtpuser:$('#smtpuser').val(),
		smtppsw:$('#smtppsw').val(),
		smtpemail:$('#smtpemail').val(),
		smtpsubject:$('#smtpsubject').val(),
		smtpcontent:$('#smtpcontent').val(),
		sitekey:$('#sitekey').val(),
		bbsmeta:$('#bbsmeta').val(),
		bbslink:$('#bbslink').val()
		},function(dat){
  		if(dat){
  			layer.open({
				  title: '成功提示'
				  ,content: '更新成功！'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.parent.location.reload();
				  }
				});  
  		}else{
  		    layer.open({
				  title: '错误提示'
				  ,content: '操作错误，更新失败！'
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