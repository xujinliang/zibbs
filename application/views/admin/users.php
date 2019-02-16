<div class="container">
  <div class="row">
      <div class="col-sm-3 hidden-xs">
	      <!-- left -->
	      <h3><i class="fa fa-navicon"></i> 菜单管理</h3>
	      <hr>
	      <ul class="nav nav-stacked">
	      	<li><a href="./index.php?route=admin/tags"><i class="fa fa-hashtag"></i> 标签</a></li>
	        <li class="active"><a href="./index.php?route=admin/users"><i class="fa fa-user"></i> 用户</a></li>
	        <li><a href="./index.php?route=admin/posts"><i class="fa fa-file"></i> 主题</a></li>
	        <li><a href="./index.php?route=admin/replies"><i class="fa fa-reply"></i> 回答</a></li>
	        <li><a href="./index.php?route=admin/clean"><i class="fa fa-send"></i> 消息清理</a></li>
	      </ul>
	      <hr>
    </div>
    <div class="col-sm-9">
      <h3>用户列表</h3>
      <hr>
      <div class="table-responsive">
		<table class="table table-striped">
			<thead><tr class="info"><td>ID</td><td>用户名</td><td>邮箱</td><td align="center">注册时间</td><td>操作</td></tr></thead>
		<?php
		if(!empty($users)){
			foreach($users as $user){	?>
				 <tr <?php if($user['status'] == '2'){echo 'class="danger"';}?><?php if($user['status'] == '0'){echo 'class="warning"';}?>>
				 	<td><?php echo $user['id'];?></td>
				 	<td><?php echo $user['username'];?></td>
				 	<td><?php echo $user['email'];?></td>
				 	<td align="center"><?php echo $user['time'];?></td>
				 	<td>
				 		<?php if($user['status'] == '2'){	?>
				 		<a class="btn btn-success btn-xs" onclick="releaseuser(<?php echo $user['id'];?>)"><i class="fa fa-plus-square" aria-hidden="true"></i> 解禁</a>
				 	<?php }if($user['status'] == '1'){?>
				 		<a class="btn btn-info btn-xs" onclick="sealuser(<?php echo $user['id'];?>)"><i class="fa fa-minus-square" aria-hidden="true"></i> 禁言</a>
				 	<?php	}if($user['status'] == '0'){	?>
				 		<a class="btn btn-warning btn-xs" title="管理员手动激活" onclick="activeuser(<?php echo $user['id'];?>)"><i class="fa fa-minus-square" aria-hidden="true"></i> 激活</a>
					<?php	}	?>
						<a class="btn btn-danger btn-xs" onclick="emptyuser(<?php echo $user['id'];?>)"><i class="fa fa-trash" aria-hidden="true"></i> 清空</a>
				 		<a class="btn btn-danger btn-xs" onclick="deleteuser(<?php echo $user['id'];?>)"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
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
function releaseuser(uid){
	$.post("./index.php?route=admin/releaseuser",{uid:uid},function(dat){
		if(dat){
  			layer.open({
				  title: '成功提示'
				  ,content: '解禁成功!'
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
function sealuser(uid){
	$.post("./index.php?route=admin/sealuser",{uid:uid},function(dat){
		if(dat){
  			layer.open({
				  title: '成功提示'
				  ,content: '禁言成功!'
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
				  ,yes: function(rel){
				  	layer.close(rel);
				  }
				});
  		}
	})
}
function activeuser(uid){
	$.post("./index.php?route=admin/activeuser",{uid:uid},function(dat){
		if(dat){
  			layer.open({
				  title: '成功提示'
				  ,content: '激活成功!'
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
function emptyuser(uid){
	var index = layer.confirm('确定要清空用户数据吗？', {
		  btn: ['确定','取消'],
		  title: ['提示', 'font-size:18px;'],
		}, function(){
			$.post("./index.php?route=admin/emptyuser",{uid:uid},function(dat){
				if(dat){
		  			layer.open({
						  title: '成功提示'
						  ,content: '清空数据成功!'
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
		}, function(){
		   layer.close(index);
		});
}
function deleteuser(uid){
	var index = layer.confirm('确定要删除吗？', {
		  btn: ['确定','取消'],
		  title: ['提示', 'font-size:18px;'],
		}, function(){
			$.post("./index.php?route=admin/deleteuser",{uid:uid},function(dat){
				if(dat){
		  			layer.open({
						  title: '成功提示'
						  ,content: '删除成功!'
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
		}, function(){
		   layer.close(index);
		});
}
</script>