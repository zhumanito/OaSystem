<?php

//命名空间的声明
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
//声明类并继承父类
class PublicController extends Controller
{
	//captcha方法
	public function captcha()
	{
		//配置
		$config = array(
					'fontSize'	=> 12,//验证码字体大小
					'useCurve'	=> false,	//是否画混淆曲线
					'useNoise'	=> false,	//是否添加杂点
					'imageH'	=> 40,
					'imageW'	=> 90,
					'length'	=> 4,	//验证码位数
					'fontttf'	=> '4.ttf',	//验证码字体不设置随机获取
			);
		//实例化验证码类
		$verify = new \Think\Verify($config);
		//输出验证码
		$verify -> entry();
	}
	//声明一个方法,登录页面展示
	public function login()
	{
		if(IS_POST)
		{
			//接收参数
			$post=I('post.');
			$username=I('post.username');
			$password=I('post.password');
			
			//验证验证码
			$verify = new \Think\Verify();
			$result = $verify->check($post['captcha']);
			if($result)
			{
				//验证码正确，继续判断用户名和密码
				//实例化模型
				$model = M('User');
				//查询
				$data = $model -> where(array('username'=>$username))->find();
				if($data)
				{
					//dump($password);die;
					if($data['password']!=$password)
					{
						$this -> error('密码错误!');
					}
					//用户存在，用户持久化session中
					session('id',$data['id']);
					session('username',$data['username']);
					//登录成功，跳转
					$this -> success('登录成功!',U('Index/index'),3);
					exit;
				}
				else
				{
					$this -> error('用户名错误!');
				}
			}
			else
			{
				$this -> error('验证码错误，请重新输入!');
			}

		}
		//展示模板
		$this -> display();
		
	}

	//退出方法
	public function logout()
	{
		//清除session
		session(null);
		//跳转到登录页面
		$this -> success('退出成功！',U('Public/login'),3);
	}
}