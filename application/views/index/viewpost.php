<script src="static/markdown/markdown.js"></script>
<script src="static/markdown/to-markdown.js"></script>
<script src="static/markdown/bootstrap-markdown.js"></script>
<script src="static/markdown/bootstrap-markdown.zh.js"></script>
<link rel="stylesheet" href="static/markdown/bootstrap-markdown.min.css">
<script src="static/dropzone/min/dropzone.min.js"></script>
<link rel="stylesheet" href="static/dropzone/min/dropzone.min.css">
<script src="static/validation/jquery.validate.min.js"></script>
<script src="static/popover/jquery.webui-popover.min.js"></script>	
<link rel="stylesheet" href="static/popover/jquery.webui-popover.min.css">
<div class="container">
  <div class="row">
    <div class="col-md-9 form-padding form-padding-view">
		<?php
		if(!empty($post)){
			$num = 0;
			foreach($post as $p){	
				if($num == '0'){	?>
			<h1><?php echo $p['title'];?></h1><hr>
			<div class="row">
				<div class="col-md-1">
					<a data-content="<a href='javascript:sendmessage(<?php echo $p['id'];?>,1)'>发短消息</a>" class="show-pop center-block" data-animation="pop" data-placement="bottom" href="javascript:;">
						<img src="<?php echo $this->general("getavatarbyuid",$p['userid']);?>" border="0" style="border-radius:50%;width:48px;">
					</a>
				</div>
				<div class="col-md-11 post-text">
					<?php echo $p['content'];?>
					<p class="pinfo"><?php echo $this->general("getnamebyuid",$p['userid']);?><span class="split"></span><small><em><?php echo date("Y-m-d H:i",strtotime($p['time']));?></em></small></p>
				</div>
			</div>
			<hr style="border:2px solid #eee">
		<?php	}	$num++;
			if(!empty($p['rcontent'])){	?>
				<div class="row">
				<div class="col-md-1">
					<a data-content="<a href='javascript:sendmessage(<?php echo $p['rid'];?>,2)'>发短消息</a>" class="show-pop center-block" data-animation="pop" data-placement="bottom" href="javascript:;">
						<img src="<?php echo $this->general("getavatarbyuid",$p['ruserid']);?>" border="0" style="border-radius:50%;width:48px;">
					</a></div>
				<div class="col-md-11 post-text">
					<?php echo $p['rcontent'];?>
					<p class="pinfo"><?php echo $this->general("getnamebyuid",$p['ruserid']);?><span class="split"></span><small><em><?php echo date("Y-m-d H:i",strtotime($p['rtime']));?></em></small></p>
				</div>
			</div>
			<hr>
		<?php	}}}	?>	
			<?php if(!empty($show)){	?>
<nav style="text-align: center"> 
<ul class="pagination">
	<?php
	foreach($show as $page){
		echo "<li>".$page."</li>";	
	}	?>
	</ul>
</nav>
	<script>
	$(function(){
		var currenturl = window.location.href.split("page=");
		var currentpage =  currenturl[1];
		$(".fy"+currentpage).parent().addClass("active");
	})	
	</script>
<?php } ?>
			<form id="replypost" role="form" class="form-padding">
			  <div class="form-group">
			    <label for="content">撰写回复<span style="color:#999;font-weight:normal">（温馨提示：需要换行请在每行末尾输入2个空格，并按回车键）</span></label>
			  	<textarea name="content" id="content" rows="10" class="required"></textarea>
			  	<script>
			  		Dropzone.autoDiscover = false;
			  		$(function(){
			  		 $("#content").markdown({
			  			language:'zh',
			  		<?php if(!empty($zibbs_userid)){	?>
			  			dropZoneOptions: {
                url:'./index.php?route=index/upload',
                maxFilesize:2,
                acceptedFiles:'image/*,application/pdf',
                dictDefaultMessage: "拖动文件到这里上传（支持JPG、GIF、PNG、PDF格式）",
					      dictFallbackMessage: "您的浏览器不支持拖放文件上传。",
					      dictFileTooBig: "文件太大 ({{filesize}}MiB). 最大支持: {{maxFilesize}}MiB.",
					      dictInvalidFileType: "您无法上传此类型的文件。",
					      dictCancelUpload: "取消上传",
					      dictCancelUploadConfirmation: "您确定要取消此上传吗？",
					      dictRemoveFile: "删除文件",
					      dictMaxFilesExceeded: "您不能再上传任何文件。",
            	}
            <?php	}	?>
			  		})
			  	})
			  	</script>
			  </div>
			  <button type="submit" class="btn btn-success pull-right">提交回复</button>
			</form>
      
    </div>
    <div class="col-md-3">
      <div class="widget-box">
      		<div style="display:flex;margin-bottom:10px;">
      			<div style="flex:1;">
      				<img src="<?php echo $userpostinfo['avatar'];?>" style="border-radius:50%;width:64px;height:64px;">
      			</div>
      			<div style="flex:2;">
      				<p style="color:#999;">自我简介: <br><?php echo !empty($userpostinfo['whoami'])?$userpostinfo['whoami']:'还没有介绍自己';?></p>
      				<p style="color:#999;">注册时间: <br><?php echo date("Y-m-d H:i",strtotime($userpostinfo['time']));?></p>
      			</div>
      		</div>
          <h2 class="h4 widget-box__title">最近发表主题</h2>
          <ul class="widget-links list-unstyled">
          	<?php
          	if(!empty($userpostlist)){
          		foreach($userpostlist as $plist){	?>
                  <li class="widget-links__item">
                  	<a href="./index.php?route=index/viewpost&pid=<?php echo $plist['id'];?>"><?php echo $plist['title'];?></a>
                          <small class="text-muted">
                                          <?php echo $plist['answers'];?> 回答
                          </small>
                  </li>
              <?php	}}	?>
          </ul>
      </div>
    </div>
  </div>
</div>
<script>
$("#replypost").validate({
	rules: {
				content:{
					required : true,
					minlength : 20
				}
			},
	messages: {
				content:{
					required : '内容不能为空',
					minlength : '至少20个字符'
				}
			},
  submitHandler: function(form) {
  	$(form).find(':button[type=submit]').prop('disabled', true);
  	var urladdr = window.location.href;
  	urladdr_arr = urladdr.split("&pid=");
  	var pid = parseInt(urladdr_arr[1]);
  	$.post("./index.php?route=index/doviewpost",{pid:pid,content:$('#content').val()},function(dat){
  		if(dat){
  			layer.open({
				  title: '成功提示'
				  ,content: '恭喜！提交回复成功'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.parent.location.href="./index.php?route=index/viewpost&pid="+pid;
				  }
				});
  		}else{
  			layer.open({
				  title: '错误提示'
				  ,content: '操作失败或尚未登陆！'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(rel){
				  	layer.close(rel);
				  	$(form).find(':button[type=submit]').prop('disabled', false);
				  }
				});
  		}
  	})
	  return false; 
	}
});
(function(){
var settings = {
		trigger:'click',
		width:90,
		multi:true,
		closeable:false,
		style:'',
		delay:300,
		padding:true
};
$('a.show-pop').webuiPopover('destroy').webuiPopover(settings);				
})();
$(window).load(function() {
  $('img').each(function() {
    if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
      this.src = './static/images/error_load.png';
    }
  });
});
</script>