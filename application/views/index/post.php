<script src="static/markdown/markdown.js"></script>
<script src="static/markdown/to-markdown.js"></script>
<script src="static/markdown/bootstrap-markdown.js"></script>
<script src="static/markdown/bootstrap-markdown.zh.js"></script>
<link rel="stylesheet" href="static/markdown/bootstrap-markdown.min.css">
<script src="static/dropzone/min/dropzone.min.js"></script>
<link rel="stylesheet" href="static/dropzone/min/dropzone.min.css">
<script src="static/validation/jquery.validate.min.js"></script>
<div class="container">
  <div class="row">
    <div class="col-md-9">
			<form id="newpost" role="form" class="form-padding">
			  <div class="form-group">
			    <label for="name">标题</label>
			    <input type="text" class="form-control required" name="title" id="title" placeholder="请输入名称">
			  </div>
			  <div class="form-group">
			    <label for="tag">选择标签</label>
			    <select name="tag" id="tag" class="form-control required">
					  <option value="">--请选择--</option>
					  <?php
					 if(!empty($showtags)){
	  		foreach($showtags as $tag){	?>
	  			<option value="<?php echo $tag['id'];?>"><?php echo $tag['name'];?></option>
	  		<?php	}}	?>
					</select>
			  </div>
			  <div class="form-group">
			    <label for="content">撰写内容<span style="color:#999;font-weight:normal">（温馨提示：需要换行请在每行末尾输入2个空格，并按回车键）</span></label>
			  	<textarea name="content" id="content" rows="10" class="required"></textarea>
			  	<script>
			  		Dropzone.autoDiscover = false;
			  		$("#content").markdown({
			  			language:'zh',
			  		<?php if(!empty($zibbs_userid)){	?>
			  			dropZoneOptions: {
                url:'./index.php?route=index/upload',
                maxFilesize:2,
                acceptedFiles:'image/*,application/pdf',
                dictDefaultMessage: "拖动文件到这里上传（支持图片、PDF格式）",
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
			  	</script>
			  </div>
			  <button type="submit" class="btn btn-success pull-right">发布主题</button>
			</form>
      
    </div>
    <div class="col-md-3">
       <div class="widget-box">
      	<?php
         if(!empty($hotposts)){	?>
          <h2 class="h4 widget-box__title">最新热门</h2>
          <ul class="widget-links list-unstyled">
          	<?php
          		foreach($hotposts as $hot){	?>
                  <li class="widget-links__item">
                  	<a href="./index.php?route=index/viewpost&pid=<?php echo $hot['id'];?>"><?php echo $hot['title'];?></a>
                          <small class="text-muted">
                                          <?php echo $hot['answers'];?> 回答
                          </small>
                  </li>
              <?php	}	?>
          </ul>
        <?php	}	?>
      </div>
    </div>
  </div>
</div>
<script>
$("#newpost").validate({
	rules: {
				title:{
					required : true,
					minlength : 10
				},
				tag: "required",
				content:{
					required : true,
					minlength : 20
				}
			},
	messages: {
				title:{
					required : '请输入标题',
					minlength : '至少10个字符'
				},
				tag: "请选择标签",
				content:{
					required : '内容不能为空',
					minlength : '至少20个字符'
				}
			},
  submitHandler: function(form) {
  	$(form).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=index/dopost",{title:$('#title').val(),tag:$('#tag').val(),content:$('#content').val()},function(dat){
  		if(dat){
  			layer.open({
				  title: '成功提示'
				  ,content: '恭喜！主题发布成功'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				    window.parent.location.href="./index.php?route=index/tag&t="+$('#tag').val();
				  }
				});
  		}else{
  			layer.open({
				  title: '错误提示'
				  ,content: '遗憾！发布失败！'
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
</script>