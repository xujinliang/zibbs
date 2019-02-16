<script src="./static/highcharts/highcharts.js"></script>
<script src="./static/highcharts/modules/exporting.js"></script>
<script src="./static/highcharts/modules/data.js"></script>
<script src="./static/highcharts/highcharts-zh_CN.js"></script>
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
	        <li><a href="./index.php?route=admin/clean"><i class="fa fa-send"></i> 消息清理</a></li>
	      </ul>
	      <hr>
    </div>
    <div class="col-sm-9">
      <h3>统计信息</h3>
			<hr>
      <div class="table-responsive">
        <div id="container" style="min-width:400px;height:400px"></div>
<script>
	$(function () {
		$.getJSON("./index.php?route=admin/backendcount",function(json){
      $('#container').highcharts({
        series: json.y,
        title: {
		        text: '<?php echo date("Y年m月",time());?>的主题数与用户数统计',
		        x: -20
		    },
		    subtitle: {
		        text: '实时数据更新',
		        x: -20
		    },
		    xAxis: {
		    		tickInterval: 2,
		       	categories: json.x
		    },
		    yAxis: {
		        title: {
		            text: '数量 (个)'
		        },
		        plotLines: [{
		            value: 0,
		            width: 1,
		            color: '#808080'
		        }]
		    },
		    tooltip: {
		        valueSuffix: '',
		        useHTML: true,
		        headerFormat: '',
		        pointFormatter: function() {
				    	 var ht = '<?php echo date("Y-m-",time());?>'+(parseInt(this.category)>10 ? this.category:'0'+this.category);
						   return '日期：'+ht+"<br>"+this.series.name+"："+this.y;
						}
		    },
		    colors: ['#019fe8', '#22ab38'],
		    legend: {
		        layout: 'vertical',
		        align: 'right',
		        verticalAlign: 'middle',
		        borderWidth: 0
		    },
		    credits:{
     				enabled:false // 禁用版权信息
				}
    });
  })
});
</script>
      </div>

      <h3>服务器信息</h3>
      <hr>
      <div class="table-responsive">
        <table class="table">
          <tr>
          	<td>操作系统 : <?PHP echo PHP_OS; ?></td><td>运行环境 : <?PHP echo $_SERVER ['SERVER_SOFTWARE']; ?> </td>	
          </tr>
          <tr>
          	<td>PHP版本 : <?PHP echo PHP_VERSION; ?></td><td>数据库版本 : <?PHP echo $mysqlversion; ?></td>	
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>