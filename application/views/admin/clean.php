<link rel="stylesheet" href="static/awesome/font-awesome.min.css">
<link rel="stylesheet" href="static/awesome/build.css">
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
	        <li class="active"><a href="./index.php?route=admin/clean"><i class="fa fa-send"></i> 消息清理</a></li>
	      </ul>
	      <hr>
    </div>
    <div class="col-sm-9">
      <h3>清理短消息</h3>
      <hr>
      <p class="bg-warning">以下列出的都是双方都删除的消息，属于数据库中的无效数据，为了减轻服务器负担，建议清理!</p>
      <div class="checkbox checkbox-danger" style="display:inline;">
		  		<input type="checkbox" id="allcheck">
		  		<label>全选</label>
		  	</div>
      <hr>
      <div class="table-responsive">
		<table class="table table-striped">
			<thead><tr class="info"><td>ID</td><td>主题</td><td>发起人</td><td>创建时间</td><td>操作</td></tr></thead>
		<?php
		if(!empty($cleanmsg)){
			foreach($cleanmsg as $msg){	?>
				 <tr>
				 	<td>
				 		<div class="checkbox checkbox-danger" style="display:inline;">
					  		<input type="checkbox" name="mid[]" value="<?php echo $msg['num'];?>">
					  		<label></label>
					  	</div>
				 		<?php echo $msg['num'];?></td>
				 	<td><?php echo $msg['subject'];?></td>
				 	<td><?php echo $this->general("getnamebyuid",$msg['updatedByUserNum']);?></td>
				 	<td><?php echo date("Y-m-d H:i:s",$msg['createdDate']);?></td>
				 	<td><a class="btn btn-danger btn-xs" onclick="deletemsg(<?php echo $msg['num'];?>)"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a></td>
				 </tr>
		<?php	}
		}
		?>
		 </table>
	   </div>
	   <hr>
	   <a class="btn btn-danger" onclick="deleteallmsg()"><i class="fa fa-trash" aria-hidden="true"></i> 批量删除</a>
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
    </div>
  </div>
</div>
<script>
$(function(){
	 $('#allcheck').click(function () {
	    var checkboxes = $("input[name='mid[]']");
	    $.each(checkboxes,function(i,cb){
	    	$(cb).prop('checked', !$(cb).prop('checked'));
	  	})
	});
})
function deletemsg(mid){
	$.post("./index.php?route=admin/deletemsg",{mid:mid},function(dat){
		if(dat){
  			layer.open({
				  title: '成功提示'
				  ,content: '删除消息成功!'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				  	window.parent.location.reload();
				  }
				});
  		}else{
  			layer.open({
				  title: '错误提示'
				  ,content: '遗憾！操作失败！'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(rel){
				  	layer.close(rel);
				  }
				});
  		}
	})
}
function deleteallmsg()
{
	var midarr = [];
	$('input[name="mid[]"]:checked').each(function(){
		midarr.push($(this).val());
	})
	if(midarr.length == '0'){
		layer.open({
		  title: '错误提示'
		  ,content: '请勾选需要删除的消息！'
		  ,icon: 5
		  ,closeBtn: 0
		  ,yes: function(rel){
		  	layer.close(rel);
		  }
		});
		return false;
	}
	$.post("./index.php?route=admin/deleteallmsg",{mid:midarr},function(dat){
		if(dat){
  			 layer.open({
				  title: '成功提示'
				  ,content: '删除消息成功!'
				  ,icon: 6
				  ,closeBtn: 0
				  ,yes: function(){
				  	window.parent.location.reload();
				  }
				});
  		}else{
  			layer.open({
				  title: '错误提示'
				  ,content: '遗憾！操作失败！'
				  ,icon: 5
				  ,closeBtn: 0
				  ,yes: function(rel){
				  	layer.close(rel);
				  }
				});
  		}
	})
}
</script>