<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/css/base.css" />
<link rel="stylesheet" href="/Public/css/info-reg.css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script src="/Public/layer/layer.js"></script>
<title>移动办公自动化系统</title>
<style type='text/css'>
	select {
		background: rgba(0, 0, 0, 0) url("/Public/images/inputbg.png") repeat-x scroll 0 0;
	    border: 1px solid #c5d6e0;
	    height: 28px;
	    outline: medium none;
	    padding: 0 8px;
	    width: 240px;
	}
	.main p input {
		float:none;
	}
</style>
</head>

<body>
<div class="title"><h2>信息登记</h2></div>
<form action="/index.php/Admin/User/add.html" method="post" id="form01">
<div class="main">
	<p class="short-input ue-clear">
    	<label>用户名：</label>
        <input name="username" type="text" placeholder="用户名" />
    </p>
	<p class="short-input ue-clear">
    	<label>密码：</label>
        <input name="password" type="password" placeholder="密码" />
    </p>
    <p class="short-input ue-clear">
    	<label>姓名：</label>
        <input name="truename" type="text" placeholder="姓名" />
    </p>
	<p class="short-input ue-clear">
    	<label>昵称：</label>
        <input name="nickname" type="text" placeholder="昵称" />
    </p>
    <div class="short-input select ue-clear">
    	<label>所属部门：</label>
        <select name="dept_id">
        	<option value="-1">请选择</option>
            <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
	<p class="short-input ue-clear">
    	<label>性别：</label>
    	<input name="sex" type="radio" value="男" checked='checked' />男
		<input name="sex" type="radio" value="女" />女
    </p>
	<p class="short-input ue-clear">
    	<label>生日：</label>
        <input name="birthday" type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" />
    </p>
	<p class="short-input ue-clear">
    	<label>联系电话：</label>
        <input type="text" name="tel" placeholder="联系电话" />
    </p>
	<p class="short-input ue-clear">
    	<label>邮箱：</label>
        <input type="text" name="email" placeholder="电子邮箱" />
    </p>
    <p class="short-input ue-clear">
    	<label>备注：</label>
        <textarea name="remark" style="font-family:Microsoft YaHei !important; font-size:14px;" placeholder="请输入内容" name="remark"></textarea>
    </p>
</div>
<div class="btn ue-clear">
    <a class="confirm" id='btnSubmit'>确定</a>
    <a href="javascript:void;" class="clear" id='btnReset'>清空内容</a>
</div>
</form>



<script type="text/javascript" src="/Public/js/common.js"></script>
<script type="text/javascript" src="/Public/js/WdatePicker.js"></script>
<script type="text/javascript">
    $("#btnSubmit").click(function(){
        $.ajax({
            type : "POST",
            url : "<?php echo U('add'); ?>",
            dataType : "json",
            data : $("#form01").serialize(),
            success : function (data)
            {
                if(data.status == 1)
                {
                    layer.msg(data.info,{icon:1},function()
                    {
                        $('#form01').reset();
                        window.location.reload();
                        exit;
                    });
                    exit;
                }else{
                    layer.msg(data.info,{icon:2});
                    exit;
                }
            },
            error : function(){
                
            }
        });
    });
    
//$(function(){
//	$('#btnSubmit').on('click',function(){
//		$('form').submit();
//	});
//	
//	$('#btnReset').on('click',function(){
//		$('form')[0].reset();
//	});
//});	

//$(".select-title").on("click",function(){
//	$(".select-list").toggle();
//	return false;
//});
//$(".select-list").on("click","li",function(){
//	var txt = $(this).text();
//	$(".select-title").find("span").text(txt);
//});
//
//showRemind('input[type=text], textarea','placeholder');
</script>


</body>


</html>