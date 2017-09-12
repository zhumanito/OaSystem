<?php
//声明命名空间
namespace Admin\Controller;

//创建一个类并继承父类
class UserController extends CommonController
{
	//showList方法
	public function showList()
	{
            //实例化模型
            $model = D('User');
            //分页第一步：查询总的记录数
            $count = $model -> count();
            //分页第二步：实例化分页类，传递参数
            $page = new \Think\Page($count,3);//每页显示1个
            //分页第三步：可选步骤，定义提示文字
            $page ->rollPage = 5;
            $page ->lastSuffix = false;
            $page ->setConfig('prev', '上一页');
            $page ->setConfig('next', '下一页');
            $page ->setConfig('last', '末页');
            $page ->setConfig('first','首页');
            //分页第四步：使用show方法生成url
            $show = $page -> show();
            //分页第五步：使用limit方法查询数据
            //展示数据
            $data = $model ->limit($page->firstRow,$page->listRows)->select();
            //分页第六步：传递模板
            $this -> assign('data',$data);
            $this -> assign('show',$show);
            //分页第七步：展示模板
            $this -> display();
	}

	//add方法
	public function add()
	{
            if(IS_POST)
            {
                $model = D('User');
                if($model->create(I('post.'),1))
                {
                    if($model->add())
                    {
                        $this->success('添加成功！');
                    }
                }else{
                    $this->error($model->getError());
                }
            }
            //查询部门信息
            $data = M('Dept') -> field('id,name') -> select();
            //分配到模板
            $this -> assign('data',$data);
            //展示模板
            $this -> display();
		
	}

	//edit方法
	public function edit()
	{
            
            //接收数据参数
            $id = I('get.id');
            if(IS_POST)
            {
                //接收参数
                $post = I('post.');
                $id= I('post.id');
                //实例化模型
                $model = D('User');
                $result = $model ->where("id=$id")->save($post);
                if($result !== false)
                {
                    //修改成功
                    $this ->success('修改成功!',U('showList'),3);
                    exit;
                }
                else
                {
                    //修改失败
                    $this ->error($model->getError());
                }
            }
            //实例化模型
            $model = D('User');
            //查询部门信息
            $data = $model -> find($id);
            //变量分配
            $this -> assign('data',$data);
            //展示模板
            $this -> display();
           
	}
        
    //charts展示图表
    public function charts()
    {
        //select t2.name as deptname,count(*) as count from sp_user as t1,sp_dept as t2 where t1.dept_id=t2.id group by deptname;
        $model = M();
        $data = $model ->field('t2.name as deptname,count(*) as count') 
                ->table('sp_user as t1,sp_dept as t2') 
                ->where('t1.dept_id=t2.id') ->group('deptname') ->select();
        //如果当前使用的PHP版本是5.6之后的版本，则可以直接将data二维数组assign不需要任何处理
        //但是当前的PHP是5.4，所以需要进行字符串拼凑
        $str = '[';
        foreach ($data as $key => $value)
        {
            $str .="['".$value['deptname']."',".$value['count']."],";
        }
        //去除最后的逗号
        $str = rtrim($str,',') . ']';
        //传递给模板
        $this ->assign('str',$str);
        //展示模板
        $this ->display();
    }

    //del方法
    public function del()
    {
        //接收数据
        $id = I('get.id');
        //实例化模型
        $model = M('User');
        $data = $model->where('id =' .$id)->delete();
        if($data)
        {
            //删除成功
            $this->success('删除成功!');
        }
        else
        {
            //删除失败
            $this->error('删除失败!');
        }
    }

}