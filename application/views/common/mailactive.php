<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>激活帐号</title>
<script src="static/js/jquery.js"></script>
<script src="static/layer/layer.js"></script>
</head>
<body>
<script>
layer.ready(function(){
	layer.alert('<?php echo $info; ?>', {icon: <?php echo $icon; ?>});
})
</script>
</body>
</html>