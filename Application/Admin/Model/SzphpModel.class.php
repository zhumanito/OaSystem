<?php

//声明命名空间
namespace Admin\Model;
//引入父类元素
use Think\Model;
//声明类并继承父类
class SzphpModel extends Model
{
	//实际数据表名，包含表前缀
	protected $trueTableName = 'Szphp';
}