<div class="container">
  <div class="row">
      <div class="col-sm-3 hidden-xs">
	      <!-- left -->
	      <h3><i class="fa fa-navicon"></i> 菜单管理</h3>
	      <hr>
	      <ul class="nav nav-stacked">
	      	<li><a href="./index.php?route=admin/tags"><i class="fa fa-hashtag"></i> 标签</a></li>
	        <li><a href="./index.php?route=admin/users"><i class="fa fa-user"></i> 用户</a></li>
	        <li class="active"><a href="./index.php?route=admin/posts"><i class="fa fa-file"></i> 主题</a></li>
	        <li><a href="./index.php?route=admin/replies"><i class="fa fa-reply"></i> 回答</a></li>
	        <li><a href="./index.php?route=admin/clean"><i class="fa fa-send"></i> 消息清理</a></li>
	      </ul>
	      <hr>
    </div>
    <div class="col-sm-9">
      <h3>主题列表</h3>
      <hr>
      <div class="table-responsive">
		<table class="table table-striped">
			<thead><tr class="info"><td>主题</td><td>用户名</td><td>创建时间</td><td>隶属</td><td>操作</td></tr></thead>
		<?php
		if(!empty($posts)){
			foreach($posts as $post){	?>
				 <tr>
				 	<td><div title="<?php echo $post['title'];?>" style="overflow: hidden;
text-overflow:ellipsis;
white-space: nowrap;width:300px;"><?php echo $post['title'];?></div></td>
				 	<td><?php echo $this->general("getnamebyuid",$post['userid']);?></td>
				 	<td><?php echo $post['time'];?></td>
				 	<td><?php echo $this->general("gettagname",$post['tagid']);?></td>
				 	<td>
				 		<a class="btn btn-warning btn-xs" onclick="movepost(<?php echo $post['id'];?>)"><i class="fa fa-exchange" aria-hidden="true"></i> 转移</a>
				 		<a class="btn btn-danger btn-xs" onclick="deletepost(<?php echo $post['id'];?>)"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
				 	</td>
				 </tr>
		<?php	}
		}
		?>
		 </table>
	   </div>
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
function movepost(pid){
	layer.open({
  	title: ['转移主题', 'font-size:18px;'],
	  type: 2,
	  content: ['./index.php?route=admin/movepost&pid='+pid, 'no'],
	  area: ['auto', '190px']
	});	
}
function deletepost(pid){
	var index = layer.confirm('确定要删除吗？', {
		  btn: ['确定','取消'],
		  title: ['提示', 'font-size:18px;'],
		}, function(){
					$.post("./index.php?route=admin/deletepost",{pid:pid},function(dat){
						if(dat){
				  			layer.open({
								  title: '成功提示'
								  ,content: '删除成功!'
								  ,icon: 6
								  ,yes: function(){
								  	window.parent.location.reload();
								  }
								});
				  		}else{
				  			layer.open({
								  title: '错误提示'
								  ,content: '遗憾！操作失败！'
								  ,icon: 5
								  ,yes: function(rel){
								  	layer.close(rel);
								  }
								});
				  		}
					})	
		}, function(){
				   layer.close(index);
		    });
}
</script>