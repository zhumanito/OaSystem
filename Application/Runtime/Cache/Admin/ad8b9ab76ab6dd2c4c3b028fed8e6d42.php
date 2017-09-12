<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>test11</title>
</head>
<body>
	个性签名：<?php echo ((isset($sign) && ($sign !== ""))?($sign):'这个家伙很懒，没有签名信息...'); ?>
</body>
</html>