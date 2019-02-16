<script src="static/validation/jquery.validate.min.js"></script>
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
<a href="javascript:history.back();" class="btn btn-link" role="button"><h5>返回消息列表</h5></a>
<?php
if(!empty($arr)){
	$systembz = false;
	foreach($arr as $p){	?>
	<div class="row msgli">
		<div class="col-md-1"><img src="<?php echo $this->general("getavatar",$p['sender']);?>" border="0" style="border-radius:50%;width:48px;"></div>
		<div class="col-md-11 post-text">
			<p><?php 
				if($this->general("getuserstatus",$p['sender'])){
					$systembz = true;
					echo htmlspecialchars_decode($p['message']);
				}else{
					echo $p['message'];
				}
			?></p>
			<a href="javascript:;"><?php echo $this->general("getname",$p['sender']);?></a> <small><?php echo $p['time'];?></small>
		</div>
	</div>
<?php	}?>
	<nav style="text-align: center"> 
		<ul class="pagination" id="pager"></ul>
	</nav>
	<script>
var liset = $("div.msgli");
var lilength = liset.length;
var pagesize = 10;
var pager = Math.ceil(lilength / pagesize);
var pagerlist = '';
for (var p = 1; p <= pager; p++) {
	if (pager <= 5) {
		if (p == 1) {
			pagerlist += "<li class='active'><a class='pagerlista' href='javascript:;' data='" + p + "'>" + p + "</a></li>";
		} else {
			pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + p + "'>" + p + "</a></li>";
		}
	} else {
		if (p == 1) {
			pagerlist += "<li class='active'><a class='pagerlista' href='javascript:;' data='" + p + "'>" + p + "</a></li>";
		} else {
			if (p > 1 && p < 5) {
				pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + p + "'>" + p + "</a></li>";
			} else if (p >= 5 && p != pager) {
				pagerlist += "<li style='display:none'><a class='pagerlista' href='javascript:;' data='" + p + "'>" + p + "</a></li>";
			} else {
				pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + p + "'>..." + p + "</a></li>";
			}
		}
	}
}
if (lilength > pagesize) {
	$("#pager").html(pagerlist);
}
liset.each(function(i) {
	if (i < pagesize) {
		$(this).show();
	} else {
		$(this).hide();
	}
})
$(document).on("click", ".pagerlista", function() {
	var pagerlist = '';
	var currentp = $(this).attr("data");
	if (currentp == 1 || currentp == 2 || currentp == 3 || currentp == 4) {
		if (parseInt(currentp) + 3 >= pager) {
			var page_tmp = pager;
		} else {
			var page_tmp = parseInt(currentp) + 3;
		}
		for (var i = 1; i <= page_tmp; i++) {
			pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + i + "'>" + i + "</a></li>";
		}
		if ((parseInt(currentp) + 3 < pager) && (parseInt(page_tmp) + 1 < pager)) {
			pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + pager + "'>..." + pager + "</a></li>";
		}
		if ((parseInt(currentp) + 3 < pager) && (parseInt(page_tmp) + 1 == pager)) {
			pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + pager + "'>" + pager + "</a></li>";
		}
	} else {
		if (currentp == pager) {
			pagerlist += "<li><a class='pagerlista' href='javascript:;' data='1'>1...</a></li>";
			for (var i = parseInt(pager) - 3; i <= pager; i++) {
				pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + i + "'>" + i + "</a></li>";
			}
		} else {
			if (currentp < parseInt(pager) - 3) {
				if (parseInt(currentp) - 5 > 0) {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='1'>1...</a></li>";
				} else {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='1'>1</a></li>";
				}
				for (var i = parseInt(currentp) - 3; i <= parseInt(currentp) + 3; i++) {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + i + "'>" + i + "</a></li>";
				}
				if (parseInt(currentp) + 3 < pager && parseInt(currentp) + 4 < pager) {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + pager + "'>..." + pager + "</a></li>";
				}
				if (parseInt(currentp) + 3 < pager && parseInt(currentp) + 4 == pager) {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + pager + "'>" + pager + "</a></li>";
				}
			} else {
				if (parseInt(currentp) - 5 > 0) {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='1'>1...</a></li>";
				} else {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='1'>1</a></li>";
				}
				for (var i = parseInt(currentp) - 3; i <= pager; i++) {
					pagerlist += "<li><a class='pagerlista' href='javascript:;' data='" + i + "'>" + i + "</a></li>";
				}
			}
		}
	}
	$("#pager").html(pagerlist);
	$(".pagerlista[data=" + currentp + "]").parent().addClass("active");
	$(".pagerlista[data=" + currentp + "]").parent().siblings().removeClass("active");
	var start = currentp * pagesize - pagesize;
	var end = currentp * pagesize;
	liset.each(function(i) {
		if (i >= start && i < end) {
			$(this).show();
		} else {
			$(this).hide();
		}
	})
})
</script>
<?php	} ?>
<?php if(!$systembz){	?>
<form id="msgform" class="form-padding">
  <div class="form-group">
    <textarea name="msgcontent" id="msgcontent" placeholder="输入您要回复的消息内容" autocomplete="off" class="form-control required" style="background-color: hsla(0,0%,71%,.1);"></textarea>
  </div>
  <div class="form-group">
  	 <input type="hidden" name="mid" id="mid" value="<?php echo $mid;?>">
      <button type="submit" class="btn btn-info">立即提交</button>
      <button type="reset" class="btn">重置</button>
  </div>
</form>
<script>
$("#msgform").validate({
	rules: {
				msgcontent: "required"
			},
	messages: {
				msgcontent: "内容不能为空"
			},
  submitHandler: function(form) {
  	$(form).find(':button[type=submit]').prop('disabled', true);
  	$.post("./index.php?route=msg/doviewmsg",{mid:$('#mid').val(),msgcontent:$('#msgcontent').val()},function(dat){
  		if(dat){
  			parent.layer.open({
				  title: '成功提示'
				  ,content: '恭喜！提交回复成功'
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
	}
});
</script>
<?php	}	?>
			</div>
		</div>
  </div>
</div>