<?php
//声明命名空间
namespace Admin\Controller;

//声明控制器类并继承父类
class DeptController extends CommonController
{
	//showList方法
	public function showList()
	{
		//实例化模型
		$model = M('Dept');
		//查询
		$data = $model-> order('sort asc')-> select();
		//二次遍历查询顶级部门
		foreach($data as $key => $value)
		{
			if($value['pid'] > 0)
			{
				//查询pid对应的部门信息
				$info = $model -> find($value['pid']);
				//只需要保留其中的name
				$data[$key]['deptname']	= $info['name'];
			}
		}
		//传递模板
		$this -> assign('data',$data);
		//展示模板
		$this -> display();
	}

	//add方法
	public function add()
	{
		//判断请求类型
		if(IS_POST)
		{
			//处理表单提交
			$post = I('post.');
			//写入数据
			$model = D('Dept');
			$data = $model -> create();//不传递参数接收post数据
			if($data)
			{
				$result = $model -> add();
				if($result)
				{
					//添加成功
					$this -> success('添加成功',U('showList'),3);
				}
				else
				{
					//添加失败
					$this -> error('添加失败');
				}
			
			}
			else
			{
				//提示用户验证失败
				$this -> error($model->getError());exit();
			}
			
		}
		else
		{
			//查询出顶级部门
			$model = M('Dept');
			$data = $model -> where('pid = 0') -> select();
			//展示数据
			//dump($data);
			$this -> assign('data',$data);
			//展示模板
			$this -> display();
		}
	}

	//edit方法
	public function edit()
	{
		
		if(IS_POST)
		{
			//处理post请求
			$post = I('post.');
			//实例化模型
			$model = M('Dept');
			$result = $model ->save($post);
			if ($result !== false) {
				//修改成功
				$this -> success('修改成功!',U('showList'),3);
			}
			else
			{
				//修改失败
				$this -> error('修改失败');
			}
		}
		else
		{
			//接收id,使用get进行接收传递的参数数据
			$id = I('get.id');
			//实例化模型
			$model = M('Dept');
			//查询部门信息
			$data = $model -> find($id);
			//查询全部的部门信息，给下拉列表使用
			$info = $model -> where("id != $id") -> select();
			//变量分配
			$this -> assign('data',$data);
			$this -> assign('info',$info);
			//展示模板
			$this -> display();
		}
	}

	//del方法
	public function del()
	{
		//接收参数
		$id = I('get.id');
		//模型实例化
		$model = M('Dept');
		//删除
		$result = $model -> delete($id);
		//判断结果
		//dump($result);die;
		if($result)
		{
			//删除成功
			$this -> success('删除成功!');
		}
		else
		{
			//删除失败
			$this -> error('删除失败!');
		}
	}
}