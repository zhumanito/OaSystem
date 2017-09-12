<?php

//声明命名空间
namespace Admin\Controller;

//声明并继承父类
class IndexController extends CommonController
{
	//index方法
	public function index()
	{
		//展示模板
		$this -> display();
	}
	//home方法
	public function home()
	{
		//展示模板
		$this -> display();
	}
}