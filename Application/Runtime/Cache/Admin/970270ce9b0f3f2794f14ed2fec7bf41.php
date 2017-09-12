<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="/Public/js/jquery.js"></script>
    </head>
    <body>
        <div>
           
            省份：
            <select name="province" id="pro1">
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["area_id"]); ?>"><?php echo ($vol["area_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            市:
            <select id="city" name="city">
                <option value="">请选择</option>
            </select>
            县：
            <select id="town" name="town">
                <option value="">请选择</option>
            </select>
            
        </div>

<script>
    $("#pro1").change(function(){
        var parent_id = $('#pro1').val();
        $.ajax({
            type:"GET",
            url:"<?php echo U('Test/getCity');?>/?parent_id="+parent_id,
            dataType:"JSON",
            success:function(data)
            {
                $('#city').empty();
                $.each(data,function(no,item){
                    $('#city').append('<option value="'+item.area_id+'">'+item.area_name+'</option>');
                });
            }
            
        });
    });
    
        $("#city").change(function(){
        var parent_id = $('#city').val();
        $.ajax({
            type:"GET",
            url:"<?php echo U('Test/getCity');?>/?parent_id="+parent_id,
            dataType:"JSON",
            success:function(data)
            {
                $('#town').empty();
                $.each(data,function(no,item){
                    $('#town').append('<option value="'+item.area_id+'">'+item.area_name+'</option>');
                });
            }
            
        });
    });
</script>
        
        
    </body>
</html>