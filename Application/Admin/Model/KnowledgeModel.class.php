<?php

//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;
class KnowledgeModel extends Model
{
	 //验证字段
    protected $insertFields=array('title','thumb','picture','description','content','author','addtime');
    protected $updateFields=array('id','title','thumb','picture','description','content','author','addtime');
    protected $_validate=array(
        array('title','require','标题不能为空!',1,'regex',3),
        array('title','1,50','标题长度为1-50个字符!',1,'length',3),
        array('author','require','作者不能空!',1,'regex',3),
        array('author','1,40','作者名称长度为1-40个字符!',1,'length',3),
        
    );
    /**
     * addData保存数据
     * @param  [type] $post [description]
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public function addData($post,$file)
    {
    	//判断是否文件需要处理
    	//要求size大于0，或者是error等于0
    	if($file['error'] == '0')
    	{
    		//有文件
    		$cfg = array('rootPath'=> WORKING_PATH . UPLOAD_ROOT_PATH);
    		//实例化上传类
    		$upload=new \Think\Upload($cfg);
    		//上传
    		$info = $upload -> uploadOne($file);
    		if($info)
    		{
    			//成功之后补全字段
    			$post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
    			//制作缩略图
    			//1.实例化类
    			$image = new \Think\Image();
    			//2.打开图片，传递图片的路径
    			$image-> open(WORKING_PATH . $post['picture']);
    			//3.制作缩略图，等比缩放
    			$image -> thumb(100,100);
    			//4.保存图片,传递保存完整路径(目录+文件名)
    			$image -> save(WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' .$info['savename']);
    			//补全thumb字段
    			$post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' .$info['savename'];
    		}
    		
    	}
    	//补全字段addtime
    	$post['addtime']=time();
    	// dump($post);die;
    	//添加操作
    	return $this-> add($post);
    }
}