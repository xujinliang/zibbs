<script type="text/javascript" src="./static/crop/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="./static/crop/js/artDialog4.1.6/jquery.artDialog.js?skin=simple"></script>
<script type="text/javascript" src="./static/crop/js/artDialog4.1.6/plugins/iframeTools.js"></script>
<div class="container">
  <div class="row form-padding">
    <ul id="myTab" class="nav nav-pills">
		    <li class="active"><a href="./index.php?route=index/mycenter">修改头像</a></li>
		    <li><a href="./index.php?route=index/mypub">我的主题</a></li>
		    <li><a href="./index.php?route=index/myrep">我的回答</a></li>
		    <li><a href="./index.php?route=msg/showmsg">我的消息</a></li>
		    <li><a href="./index.php?route=index/mypsw">修改密码</a></li>
		    <li><a href="./index.php?route=index/whoami">自我介绍</a></li>
		</ul>
		<div id="myTabContent" class="tab-content form-padding">
		    <div class="tab-pane fade in active">
		        <script>
$(document).ready(function(e){
	$('#head_photo').on('change',function(){ 
		ajaxFileUploadview('head_photo','photo_pic',"./static/crop/upload.php");
	});
});
function show_head(head_file){
		$("#head_photo_src").attr('src','<?php echo $siteurl;?>/static/images/'+head_file);
		$.post("./index.php?route=index/doavatar",{avatar:'static/images/'+head_file},function(dat){
			if(dat){
			parent.layer.open({
			  title: '成功提示'
			  ,content: '头像更新成功！'
			  ,icon: 6
			  ,closeBtn: 0
			  ,yes: function(rel){
			  	parent.layer.close(rel);
			  }
			});
		}else{
				parent.layer.open({
				  title: '错误提示'
				  ,content: '操作失败，请重试'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(rel){
				  	parent.layer.close(rel);
				  }
				});
			}
		})
}
//文件上传带预览
function ajaxFileUploadview(imgid,hiddenid,url){
$.ajaxFileUpload
({
	url:url,
	secureuri:false,
	fileElementId:imgid,
	dataType: 'json',
	data:{name:'logan', id:'id'},
	success: function (data, status)
	{
		if(typeof(data.error) != 'undefined')
		{
			if(data.error != '')
			{
				var dialog = art.dialog({title:false,fixed: true,padding:0});
				dialog.time(2).content("<div class='tips'>"+data.error+"</div>");
			}else{
				var resp = data.msg;						
				if(resp != '0000'){
					var dialog = art.dialog({title:false,fixed: true,padding:0});
					dialog.time(2).content("<div class='tips'>"+data.error+"</div>");
					return false;
				}else{
					$('#'+hiddenid).val(data.imgurl);						
					art.dialog.open("./static/crop/crop_image.php?img="+data.imgurl,{
						title: '裁剪头像',
						width:'580px',
						height:'400px'
					});
				}
			}
		}
	},
	error: function (data, status, e)
	{
		dialog.time(3).content("<div class='tips'>"+e+"</div>");
	}
})
return false;
}
</script>
<a href="javascript:;" class="file">修改头像
<input type="file" name="head_photo" id="head_photo" value="">
</a>
<input type="hidden" name="photo_pic" id="photo_pic" value="">
<div id="show_photo" style="border:1px solid #f7f7f7;width:64px;height:64px;margin-top:10px;">
	当前头像:<img id="head_photo_src" border="0" src="<?php echo $avatar;?>">
</div>
<style>
.file {
    position: relative;
    display: inline-block;
    background: #D0EEFF;
    border: 1px solid #99D3F5;
    border-radius: 4px;
    padding: 4px 5px;
    overflow: hidden;
    color: #1E88C7;
    text-decoration: none;
    text-indent: 0;
    line-height: 20px;
    font-size:14px;
}
.file input {
    position: absolute;
    font-size: 100px;
    right: 0;
    top: 0;
    opacity: 0;
}
.file:hover {
    background: #AADFFD;
    border-color: #78C3F3;
    color: #004974;
    text-decoration: none;
}	
</style>
		    </div>
		</div>
  </div>
</div>