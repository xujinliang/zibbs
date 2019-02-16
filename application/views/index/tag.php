<div class="container">
  <div class="row">
    <div class="col-md-9">
    	<?php
    	if($tagdesc){	?>
    	<div class="row grid-demo grid-demo-bg1 tag__info">
	        <?php echo $tagdesc['description'];?>
	    </div>
	  	<?php	}	?>
      <div class="stream-list question-stream">
       <?php
       if(!empty($allposts)){
       	foreach($allposts as $p){	?>                                  
        <section class="stream-list__item">
                <div class="qa-rank">
            <div class="answers <?php if($p['answers']>0){echo 'answered';}else{echo 'unanswered';}?>">
                <?php echo $p['answers']>9999 ? '1万+' : $p['answers'];?><small>回答</small>
            </div>
                        <div class="views hidden-xs">
                <span><?php echo $p['views']>9999 ? '1万+' : $p['views'];?></span>
                <small>浏览</small>
            </div>
                    </div>
        <div class="summary">
            <h2 class="title"><a href="./index.php?route=index/viewpost&pid=<?php echo $p['id'];?>"><?php echo $p['title'];?></a></h2>
            <ul class="author list-inline">
                                                <li>
                                            <a href="javascript:;" onclick="showwho(this,<?php echo $p['userid'];?>)"><?php echo $p['username'];?></a>
                        <span class="split"></span>
                        <small><?php echo $p['time'];?></small>
                                    </li>
            </ul>
        </div>
    </section>
<?php	}}	?>
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
    <div class="col-md-3">
     <div class="widget-box">
      <?php
       if(!empty($hotposts)){	?>
      	<h2 class="h4 widget-box__title">当前热门</h2>
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
function showwho(_this,uid){
	$.post("./index.php?route=index/querywhoami",{uid:uid},function(dat){
  	var data=eval("("+dat+")");
  	layer.tips('用户名：'+data.username+'<br>注册时间：'+data.time+'<br>自我介绍：'+data.whoami, _this,{
			  tips: [1, '#3595CC'],
			  time: 2000
			});
  })
}
</script>