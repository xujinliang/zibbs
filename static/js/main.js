$(function(){
	$(".registerbtn").click(function(){
		  layer.open({
		  	title: ['用户注册', 'font-size:18px;'],
			  type: 2,
			  content: ['./index.php?route=Common/registerform', 'no'],
			  area: ['auto', '400px']
			});
	})
	
	$(".loginbtn").click(function(){
		  layer.open({
		  	title: ['用户登录', 'font-size:18px;'],
			  type: 2,
			  content: ['./index.php?route=Common/loginform', 'no'],
			  area: ['auto', '300px']
			});
	})
})
function sendmessage(lid,set){
	layer.open({
		  	title: ['短消息', 'font-size:18px;'],
			  type: 2,
			  content: ['./index.php?route=msg/sendmsg&lid='+lid+'+&set='+set, 'no'],
			  area: ['auto', '270px']
			});
}