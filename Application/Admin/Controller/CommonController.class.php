<?php
//声明命名空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
//创建一个类并继承父类控制器
class CommonController extends Controller
{
	//构造方法
	// public function __construct()
	// {
	// 	//构造父类
	// 	parent::__construct();

	// 	echo '您好世界';
	// }

	//ThinkPHP提供
	public function _initialize()
	{
		//判断用户是否登录
		$id=session('id');
		//判断用户是否登录
		if(empty($id))
		{
			//没有登录，跳转到登录页面
			// $this->error('请先登录......',U('Public/login'),3);
			// exit;
			// 编写javascript代码
			$url = U('Public/login');
			echo "<script>top.location.href='$url'</script>";exit;
		}

		//RBAC部分
		$role_id = session('role_id');//获取当前角色用户的id
		$rabc_role_auths = C('RBAC_ROLE_AUTHS');//获取全部的用户组的权限
		$currRoleAuth=$rabc_role_auths['id'];

		//使用常量获取当前路由中的控制器名和方法名
		$controller = strtolower(CONTROLLER_NAME);
		$action = strtolower(ACTION_NAME);

		//判断权限是否具有
		if($role_id > 1)
		{
			//当用户不是超级管理员的时候进行权限判断
			if(!in_array($controller .'/' . $action, $currRoleAuth) && !in_array($controller . '/*',$currRoleAuth))
			{
				//用户没有权限
				$this->error('您没有权限!',U('Index/home'),3);
				exit;
			}
		}
	}
}