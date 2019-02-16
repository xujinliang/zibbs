<div class="container">
  <div class="row">
    <div class="col-md-9">
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
                                            <?php echo $p['username'];?>
                        <span class="split"></span>
                        <small><em><?php echo date("Y-m-d H:i",strtotime($p['time']));?></em></small>
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
      	if(!empty($settingarr['bbsmeta'])){
      		echo htmlspecialchars_decode($settingarr['bbsmeta']);
      	}
      	if(!empty($settingarr['bbslink'])){
      		echo '<p style="margin:20px 0">友情链接: </p>';
      		$bbslinks = explode("\n",$settingarr['bbslink']);
      		foreach($bbslinks as $bbslink){
      			$bbslinktmp = explode("|",$bbslink);
      			echo '<p><a target="_blank" href="'.trim($bbslinktmp[1]).'">'.trim($bbslinktmp[0]).'</a></p>';
      		}
      	}
      	?>
      </div>
    </div>
  </div>
</div>