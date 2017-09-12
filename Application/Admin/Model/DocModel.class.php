<?php

//声明一个模型
namespace Admin\Model;
//引入父类模型
use Think\Model;
//声明一个类并继承父类模型
class DocModel extends Model
{
    //验证字段
    protected $insertFields=array('title','filepath','filename','hasfile','content','author','addtime');
    protected $updateFields=array('id','title','filepath','filename','hasfile','content','author','addtime');
    protected $_validate=array(
        array('title','require','标题不能为空!',1,'regex',3),
        array('title','1,50','标题长度为1-50个字符!',1,'length',3),
        array('author','require','作者不能空!',1,'regex',3),
        array('author','1,40','作者名称长度为1-40个字符!',1,'length',3),
        
    );
    
    //saveData
    public function saveData($post,$file)
    {
        
        //先判断是否有文件需要处理
        if(!$file['error'])
        {
            //定义配置
            $cfg = array(
                //配置上传路径
                'rootPath'  => WORKING_PATH . UPLOAD_ROOT_PATH
            );
            //处理上传
            $upload = new \Think\Upload($cfg);
            //开始上传
            $info = $upload->uploadOne($file);
            //判断是否上传成功
            if($info)
            {
                //补齐剩余的三个字段
                $post['filepath']=UPLOAD_ROOT_PATH . $info['savepath'] .$info['savename'];
                $post['filename']=$info['name'];//文件的原始名
                $post['hasfile']=1;
            }
            else
            {
                //A方法实例化控制器
                A('Doc')->error($upload->getError());
                exit;
            }
        }
        $post['addtime']=time();
        //实例化模型
       // $this->create($post);
        //添加操作
        return  $this->add($post);
    }
    //更新数据保存
    public function updateData($post,$file)
    {
        //如果有文件则处理文件
        if($file['error']=='0')
        {
            //有文件
            //配置数组
            $cfg=array('rootPath'=>WORKING_PATH . UPLOAD_ROOT_PATH);
            //实例化上传类
            $upload = new \Think\Upload($cfg);
            //上传
            $info = $upload ->uploadOne($file);
            //判断上传的结果
            if($info)
            {
                //成功
                $post['filepath']= UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['filename'] =$info['name'];
                $post['hasfile']= 1;
                
            }
        }
        //写入数据
        //dump($post);die;
        return $this->save($post);
    }
}
