<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if($day==1): ?>星期一
	<elseif condition='$day==2'>
	星期二
	<elseif condition='$day==3'>
	星期三
	<elseif condition='$day==4'>
	星期四
	<elseif condition='$day==5'>
	星期五
	<elseif condition='$day==6'>
	星期六
	<?php else: ?>
	星期天<?php endif; ?>
</body>
</html>