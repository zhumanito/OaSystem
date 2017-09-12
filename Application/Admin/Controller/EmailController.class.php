<?php
//声明命名空间
namespace Admin\Controller;

class EmailController extends CommonController
{
	/**
	 * send方法，展示模板+数据保存
	 * @return [type] [description]
	 */
	public function send()
	{
		if(IS_POST)
		{
			//处理数据
			//接收数据
			$post = I('post.');
			//实例化自定义模型
			$model = D('Email');
			//调用具体类中方法实现数据的保存
			$result = $model->addData($post,$_FILES['file']);
			//判断结果
			if($result)
			{
				//成功
				$this->success('邮件发送成功!',U('sendBox'),3);
			}
			else
			{
				//失败
				$this->error('邮件发送失败!');
			}

		}
		else
		{
			//查询收件人的信息
			$data = M('User')->field('id,truename')->where("id !=" .session('id'))->select();
			//传递数据
			$this->assign('data',$data);
			//展示模板
			$this->display();
		}
		
		
	}
	public function sendBox()
	{
		
		//实例化模型
		$model = M('Email');
		$data=$model->field('t1.*,t2.truename as truename')->alias('t1')
		->join('left join sp_user as t2 on t1.to_id=t2.id')->where('t1.from_id=' . session('id'))->select();
		//传递参数
		$this->assign('data',$data);
		//展示模板
		$this->display();
	}
	/**
	 * 获取数据，展示模板
	 * @return [type] [description]
	 */
	public function receiveBox()
	{
		$data =M('Email')->field('t1.*,t2.truename as truename')
			->alias('t1')->join('left join sp_user as t2 on t1.from_id=t2.id')
			->where('t1.to_id= '.session('id'))->select();
		//传递数给模板
		$this->assign('data',$data);
		//展示模板
		$this->display();
	}
	/**
	 * 下载功能的实现
	 * @return [type] [description]
	 */
	public function download()
	{
		//接收id
		$id=I('get.id');
		//查询信息
		$data = M('Email')->find($id);
		$file = WORKING_PATH . $data['file'];
		header("Content-type:application/octet-stream");
		header('Content-Disposition:attachment;filename="' . basename(file) . '"');
		header("Content-Length:" . filesize($file));
		readfile($file);
		
	}
	//空操作
	public function _empty()
	{
		//输出
		$this->display('Empty/error');
	}

	//getContent方法
	public function getContent()
	{
		//获取id
		$id=I('get.id');
		//查询数据
		$data = M('Email')->where("id = $id and to_id =" .session('id'))->find();
		// dump($data);die;
		//如果data为真则修改邮件的状态
		if($data['isread'] == '0')
		{
			//修改状态
			M('Email') -> save(array('id' => $id,'isread' => 1));
		}
		//输出内容
		echo $data['content'];
	}

	//getCount方法 当前未读邮件的数量
	public function getCount()
	{
		
		if(IS_AJAX)
		{
			//实例化模型
			$model = M('Email');
			//查询当前用户未读邮件的数量
			$count = $model->where("isread = 0 and to_id = " .session('id'))->count();
			//输出数字
			echo $count;
		}
	}
}