<div class="container">
  <div class="row form-padding">
    <ul id="myTab" class="nav nav-pills">
		    <li><a href="./index.php?route=index/mycenter">修改头像</a></li>
		    <li><a href="./index.php?route=index/mypub">我的主题</a></li>
		    <li><a href="./index.php?route=index/myrep">我的回答</a></li>
		    <li class="active"><a href="./index.php?route=msg/showmsg">我的消息</a></li>
		    <li><a href="./index.php?route=index/mypsw">修改密码</a></li>
		    <li><a href="./index.php?route=index/whoami">自我介绍</a></li>
		</ul>
		<div id="myTabContent" class="tab-content form-padding">
		    <div class="tab-pane fade in active">
<link rel="stylesheet" href="static/awesome/font-awesome.min.css">
<link rel="stylesheet" href="static/awesome/build.css">
<?php
if(!empty($arr['results'])){ ?>
	<form id="delform">
		<ul class="list-group msgulresult">
		<?php	foreach($arr['results'] as $v){ ?>
		  <li class="list-group-item <?php if(isset($v['message_read']) && $v['message_read']){echo 'list-group-item-success';}?>">
		  	<div class="checkbox checkbox-danger" style="display:inline;">
		  		<input type="checkbox" name="mid[]" value="<?php echo $v['mid'];?>">
		  		<label></label>
		  	</div>
		  	<a href="./index.php?route=msg/viewmsg&mid=<?php echo $v['mid'];?>"><?php echo $v['subject'];?></a>
		  	<small>&nbsp;&nbsp;<?php echo $v['lastupdated'];?></small>
		  	<span class="badge"><?php 
		  		if($v['receiver'] == '我'){
		  			echo $this->general("getname",$v['sender']).' —> '.$v['receiver'];
			  	}else{
			  		echo $v['sender'].'  —> '.$this->general("getname",$v['receiver']);
			  	}
		  	?></span>
		  </li>
		<?php	}	?>
		</ul>
		<input type="submit" name="del" class="btn btn-danger" value="删除消息">
	</form>
	
	<nav style="text-align: center"> 
<ul class="pagination">
	<?php
	foreach($arr['show'] as $page){
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
	
<?php	} ?>

<script>
$("#delform").submit(function(){
	$(this).find(':input[type=submit]').prop('disabled', true);
	var midarr = [];
	$('input[name="mid[]"]:checked').each(function(){
		midarr.push($(this).val());
	})
	if(midarr.length == '0'){
		parent.layer.open({
		  title: '错误提示'
		  ,content: '请勾选需要删除的消息！'
		  ,icon: 5
		  ,closeBtn: 0
		  ,yes: function(rel){
		  	parent.layer.close(rel);
		  }
		});
		$(this).find(':input[type=submit]').prop('disabled', false);
		return false;
	}
$.post("./index.php?route=msg/dodelmsg",{mid:midarr},function(dat){
	if(dat){
		parent.layer.open({
		  title: '成功提示'
		  ,content: '恭喜！删除消息成功'
		  ,icon: 6
		  ,closeBtn: 0
		  ,yes: function(){
			    window.location.href='./index.php?route=msg/showmsg';
		  }
		});
	}else{
		parent.layer.open({
		  title: '错误提示'
		  ,content: '遗憾！操作失败！'
		  ,icon: 5
		  ,closeBtn: 0
		  ,yes: function(rel){
		  	parent.layer.close(rel);
		  }
		});
	}
})
return false;
})
</script>
			</div>
		</div>
  </div>
</div>