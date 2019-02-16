<?php
$pic_name=isset($_REQUEST['pic_name'])?$_REQUEST['pic_name']:'';
$x=isset($_REQUEST['x'])?$_REQUEST['x']:'';
$y=isset($_REQUEST['y'])?$_REQUEST['y']:'';
$w=isset($_REQUEST['w'])?$_REQUEST['w']:'';
$h=isset($_REQUEST['h'])?$_REQUEST['h']:'';
$targ_w = $targ_h = 64;
include_once("jcrop_image.class.php");
$filep="../images/avatar/";
$crop=new jcrop_image($filep, $pic_name,$x,$y,$w,$h,$targ_w,$targ_h);
$file=$crop->crop();
?>