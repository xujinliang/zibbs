<?php
$maxSize  = 1024*1024 ;//1M 设置附件上传大小
$allowExts  = array("gif","jpg","jpeg","png");// 设置附件上传类型

include_once("UploadFile.class.php");
$upload = new UploadFile();// 实例化上传类
$upload->maxSize = $maxSize;
$upload->allowExts = $allowExts;
$upload->savePath =  '../images/avatar/';// 设置附件
$upload->saveRule = time().sprintf('%04s',mt_rand(0,1000));
if(!$upload->upload()) {// 上传错误提示错误信息
	$errormsg = $upload->getErrorMsg();
	$arr =  array(
		'msg'=>'1111',
		'error'=>$errormsg, //返回错误
		'imgurl'=>'',//返回图片名
	);
	echo json_encode($arr);
	exit;
	
}else{// 上传成功 获取上传文件信息
	$info =  $upload->getUploadFileInfo();
	$imgurl = $info[0]['savename'];
}
$arr =  array(
	'msg'=>'0000',
	'error'=>'', //返回错误
	'imgurl'=>$imgurl,//返回图片名
);
echo json_encode($arr);
exit;
?>