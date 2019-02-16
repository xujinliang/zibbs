<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="../favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<link rel="bookmark" href="../favicon.ico" type="image/x-icon">
<title>梓论坛 &rsaquo; 调整配置文件</title>
<script>
function check(){
	if (navigator.userAgent.indexOf("MSIE") > 0) {
	var msg='';
		if(document.forms['form'].dbname.value==''){
			msg += "数据库名必填！\r\n";
		}if(document.forms['form'].uname.value==''){
			msg += "数据库用户名必填！\r\n";
		}if(document.forms['form'].auser.value==''){
			msg += "管理员帐户必填！\r\n";
		}if(document.forms['form'].apass.value==''){
			msg += "管理员密码必填！\r\n";
		}if(document.forms['form'].root.value==''){
			msg += "论坛网址必填！\r\n";
		}
	if(msg==''){
		return true;
	}else{
		alert(msg);
		return false;
	}
 }
 return true;
}
</script>
</head>
<body>
	<?php
$status = file_get_contents("./status.txt");
if ($status != "complete") {
?>
<link rel="stylesheet" href="css/install.css?ver=3.4.2" type="text/css" />
<h1 id="logo">梓论坛安装…</h1>
<?php
	if(isset($_POST['submit'])&&$_GET['step']==2){
		foreach($_POST as $k=>$v){
			$_POST[$k] = addslashes($v);
		}
		if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$_POST['auser']) || 
			!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$_POST['apass'])){
	    	die('管理员帐户或密码中含有非法字符，请返回重新安装');
	    }
		try{
			$db = new PDO('mysql:host='.$_POST['dbhost'], $_POST['uname'], $_POST['pwd'],array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true)); //初始化一个PDO对象
		} catch (PDOException $e) {
		    die ('无法连接数据库服务器，请检查数据库是否存在并重新安装<br>错误信息: ' . $e->getMessage());
		}
		
		require('../core/encrypt.php');
		$key = require('../config/key.php');
		$conf=file_get_contents("../config/config.php");
		$conf=str_replace("{db_host}",$_POST['dbhost'],$conf);
		$conf=str_replace("{db_name}",$_POST['dbname'],$conf);
		$conf=str_replace("{db_user}",$_POST['uname'],$conf);
		$conf=str_replace("{db_psw}",$_POST['pwd'],$conf);
		file_put_contents("../config/config.php",$conf);
		echo '<img src="./green.jpg" border=0 style="float:left;"><span style="margin-left:10px;float:left;font-size:13px">../Conf/config.php 配置成功！</span><br><br>';
		
		$sql=file_get_contents("./zibbs.sql");
		$sql_arr=explode(";##",$sql);
		try{
			$db = new PDO('mysql:host='.$_POST['dbhost'].';dbname='.$_POST['dbname'], $_POST['uname'], $_POST['pwd'],array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true)); //初始化一个PDO对象
		} catch (PDOException $e) {
		    die ('无法连接数据库，请检查数据库是否存在并重新安装<br>错误信息: ' . $e->getMessage());
		}
		$db->exec("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
    $db->exec("SET sql_mode=''");
		$sql_arr_count=sizeof($sql_arr);
		for($i=0;$i < $sql_arr_count;$i++){
			$db->exec($sql_arr[$i]);
		}
		$db->exec("insert into zibbs_admin(username,password) values('".$_POST['auser']."','".cc_encrypt($_POST['apass'],$key)."')");
		$db->exec("update zibbs_setting set siteurl='".$_POST['root']."' where id=1");
		$db->exec("insert into zibbs_user(username,password,email,avatar,status,time) values('【系统通知】','".cc_encrypt('123123',$key)."','system@zibbs.youyax.com','static/images/system.jpg','-1',now())");
		echo '<img src="./green.jpg" border=0 style="float:left;"><span style="margin-left:10px;float:left;font-size:13px">数据库语句执行配置成功！</span><br><br>';
		file_put_contents('./status.txt','complete');
		echo '系统安装成功，即将跳转到主页……';
		echo '<script>setTimeout(function(){window.location.href="'.$_POST['root'].'"},5000);</script>';
		exit;
	}
}else{
	?>
<style type="text/css">
	#exception{
  font-family:'隶书';
				text-align:center;
				width:350px;
				height:60px;
				line-height:60px;
				background:#f4e1d5;
				position:fixed;
  			margin:auto;
  			left:0; right:0; top:0; bottom:0;
  			box-shadow: rgb(255, 255, 255) 0px 0px 100px;
  			-webkit-box-shadow: rgb(255, 255, 255) 0px 0px 100px;
  			-moz-border-radius: 20px;
  			-khtml-border-radius: 20px;
  			-webkit-border-radius: 20px;
  			border-radius: 20px;
  }
	body{
				background:#a6a6a6;
			}
</style>
	<div id="exception">
				<span style="font-family:Tahoma;font-size:14px;display:block;height:14px;margin-top:-10px;">操作错误</span>
				<span style="color:red;font-family:Verdana;font-size:14px;font-weight:700;display:block;height:14px;margin-top:6px;">重新安装，需清空status.txt</span>
		</div>
<?php
}
if ($status != "complete") {
	if (!extension_loaded('curl')) {
		echo '<img src="./red.jpg" border=0 style="float:left;"><span style="float:left;font-size:13px">系统检测到当前没有开启php_curl.dll拓展</span><br>';
	}
	if (!extension_loaded('mbstring')) {
		echo '<img src="./red.jpg" border=0 style="float:left;"><span style="float:left;font-size:13px">系统检测到当前没有开启php_mbstring.dll拓展</span><br>';
	}
?>
<form name="form" method="post" action="index.php?step=2" onsubmit="return check();">
	<p>请在下方填写您的数据库连接信息。如果您不确定，请联系您的服务提供商。</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">数据库名</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="" placeholder="必填项" required="required"/></td>
			<td>将 梓论坛 安装到哪个数据库？</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">用户名</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="" placeholder="必填项" required="required"/></td>
			<td>您的 MySQL 用户名</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">密码</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value=""/></td>
			<td>&hellip;及其密码</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">数据库主机</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>如果填写 <code>localhost</code> 之后论坛不能正常工作的话，请向主机服务提供商索要数据库信息。</td>
		</tr>
		<tr>
			<th scope="row"><label for="auser">管理员帐户</label></th>
			<td><input name="auser" id="auser" type="text" size="25" value="" placeholder="必填项" required="required" minlength="2" maxlength="7"/></td>
			<td>管理员帐户,长度必须在3~12个字符之间</td>
		</tr>
		<tr>
			<th scope="row"><label for="apass">管理员密码</label></th>
			<td><input name="apass" id="apass" type="text" size="25" value="" placeholder="必填项" required="required"/></td>
			<td>管理员密码</td>
		</tr>
		<tr>
			<th scope="row"><label for="root">论坛网址</label></th>
			<td><input name="root" id="root" type="text" size="25" value="" placeholder="必填项" required="required"/></td>
			<td>填写例如"http://xxx.com 或带子目录http://xxx.com/xxx"</td>
		</tr>
	</table>
		<p class="step"><input name="submit" type="submit" value="提交" class="button" /></p>
</form>
<?php
}
?>
</body>
</html>
