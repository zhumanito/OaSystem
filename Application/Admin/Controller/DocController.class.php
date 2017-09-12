<?php

//声明命令空间
namespace Admin\Controller;

//声明一个类并继承父类
class DocController extends CommonController
{
    //add方法
    public function add()
    {
        //判断请求类型
        if(IS_POST)
        {
            //处理提交
            $post=I('post.');
            //实例化模型
            $model=D('Doc');
            //$model->create($post);
            $result=$model->saveData($post,$_FILES['file']);
            //判断保存结果
            if($result)
            {
                //成功
                $this->success('添加成功!',U('showList'),3);
                exit;
            }
            else
            {
                $this->error($model->getError());
            }
            
        }
        //展示模板
        $this->display();
    }
    
    //showList方法
    public function showList()
    {
        //实例化模型
        $model=D('Doc');
        $data=$model->select();
        $this->assign('data',$data);
        //展示模板
        $this->display();
    }
    
    //download方法
    public function download()
    {
        //接收id
        $id =I('get.id');
        //查询数据
        $data=M('Doc')->find($id);
        //下载代码
        $file = WORKING_PATH . $data['filepath'];
        //输出文件
        header("Content-type:application/octet-stream");
        header('Content-Disponsition:attachment;filename="' .basename($file) .'"');
        header("Content-Length:".filesize($file));
        //输出缓存区
        readfile($file);
    }
    
    //showContent方法
    public function showContent()
    {
        //接收id
        $id = I('get.id');
        //查询数据
        $data = M('Doc') ->find($id);
        //输出内容，并且还原被转移的字符
        echo htmlspecialchars_decode($data['content']);
    }
    /**
     * 编辑数据提交保存
     * @return [type] [description]
     */
    public function edit()
    {
    	//判断请求数据的提交
    	if(IS_POST)
    	{
    		//处理数据的提交
    		$post=I('post.');
    		//实例化自定义模型
    		$model=D('Doc');
    		//调用updateData方法实现数据的保存
    		$result= $model->updateData($post,$_FILES['file']);
    		//判断返回值是否为真
    		if($result)
    		{
    			//成功
    			$this->success('修改成功!',U('showlist'),3);
    		}
    		else
    		{
    			//失败
    			$this->error('修改失败!');
    		}
    	}
    	else
    	{
    		//接收数据
    		$id=I('get.id');
    		//查询数据
    		$data=M('Doc')->find($id);
    		//变量分配
    		$this->assign('data',$data);
    		$this->display();
    	}
    }

    //del方法删除
    public function del()
    {
        //接收数据
        $id = I('get.id');
        //实例化模型
        $model = M('Doc');
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


