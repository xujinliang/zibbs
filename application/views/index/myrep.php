<div class="container">
  <div class="row form-padding">
    <ul id="myTab" class="nav nav-pills">
		    <li><a href="./index.php?route=index/mycenter">修改头像</a></li>
		    <li><a href="./index.php?route=index/mypub">我的主题</a></li>
		    <li class="active"><a href="./index.php?route=index/myrep">我的回答</a></li>
		    <li><a href="./index.php?route=msg/showmsg">我的消息</a></li>
		    <li><a href="./index.php?route=index/mypsw">修改密码</a></li>
		    <li><a href="./index.php?route=index/whoami">自我介绍</a></li>
		</ul>
		<div id="myTabContent" class="tab-content form-padding">
		    <div class="tab-pane fade in active">
<?php
if(!empty($myreps)){	?>
	<ul class="list-group myrepulresult">
	<?php
	foreach($myreps as $rep){	?>
		<li class="list-group-item">
			<a target="_blank" href="./index.php?route=index/viewpost&pid=<?php echo $rep['id'];?>"><?php echo $rep['title'];?></a>
		</li>
	<?php 	}	?>
</ul>
<?php
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
</div>