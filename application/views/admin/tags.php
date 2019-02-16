<div class="container">
  <div class="row">
      <div class="col-sm-3 hidden-xs">
	      <!-- left -->
	      <h3><i class="fa fa-navicon"></i> 菜单管理</h3>
	      <hr>
	      <ul class="nav nav-stacked">
	      	<li class="active"><a href="./index.php?route=admin/tags"><i class="fa fa-hashtag"></i> 标签</a></li>
	        <li><a href="./index.php?route=admin/users"><i class="fa fa-user"></i> 用户</a></li>
	        <li><a href="./index.php?route=admin/posts"><i class="fa fa-file"></i> 主题</a></li>
	        <li><a href="./index.php?route=admin/replies"><i class="fa fa-reply"></i> 回答</a></li>
	        <li><a href="./index.php?route=admin/clean"><i class="fa fa-send"></i> 消息清理</a></li>
	      </ul>
	      <hr>
    </div>
    <div class="col-sm-9">
      <h3>标签列表</h3>
		<hr>
		<a class="btn btn-success" onclick="addnew()"><i class="fa fa-plus" aria-hidden="true"></i> 新建标签</a>
		<hr>
		<?php
		if(!empty($tags)){
			foreach($tags as $tag){	?>
				<div class="panel panel-default">
				  <div class="panel-heading"><?php echo $tag['name'];?>
				  	<div class="pull-right" style="top: -8px;position: relative;">
				  		<a class="btn btn-warning" onclick="edittag(<?php echo $tag['id'];?>)"><i class="fa fa-pencil" aria-hidden="true"></i> 修改</a>
				  		<a class="btn btn-danger" onclick="deletetag(<?php echo $tag['id'];?>)"><i class="fa fa-trash" aria-hidden="true"></i> 删除</a>
				  	</div>
				  </div>
				  <div class="panel-body">
				    <?php echo $tag['description'];?>
				  </div>
				</div>
		<?php	}
		}
		?>
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
function addnew(){
  layer.open({
  	title: ['新增标签', 'font-size:18px;'],
	  type: 2,
	  content: ['./index.php?route=admin/addtag', 'no'],
	  area: ['auto', '400px']
	});
}
function edittag(tagid){
	layer.open({
  	title: ['编辑标签', 'font-size:18px;'],
	  type: 2,
	  content: ['./index.php?route=admin/edittag&tagid='+tagid, 'no'],
	  area: ['auto', '400px']
	});
}
function deletetag(tagid){
	var index = layer.confirm('确定要删除吗？', {
		  btn: ['确定','取消'],
		  title: ['提示', 'font-size:18px;'],
		}, function(){
		  	$.post('./index.php?route=admin/deletetag',{tagid:tagid},function(dat){
		  		if(dat){
		  			layer.open({
						  title: '成功提示'
						  ,content: '标签删除成功！'
						  ,icon: 6
						  ,closeBtn: 0
						  ,yes: function(){
						    window.parent.location.reload();
						  }
						});  
		  		}else{
		  			layer.open({
						  title: '错误提示'
						  ,content: '操作错误，删除失败！'
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