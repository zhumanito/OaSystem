<?php
//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;
//声明并继承父类模型
class EmailModel extends Model
{
	/**
	 * addData
	 * @param [type] $post [description]
	 * @param [type] $file [description]
	 */
	public function addData($post,$file)
	{
		//数据分为文件+字符
		if($file['error']== '0')
		{
			//有文件需要处理
			$cfg = array('rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH);
			//实例化上传类
			$upload = new \Think\Upload($cfg);
			//开始上传
			$info = $upload->uploadOne($file);
			//判断上传结果
			if($info)
			{
				//上传成功，此时需要处理数据
				//file 、hasfile、filename
				$post['file'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];   //文件在磁盘上的存储路径
				$post['hasfile']='1';	//表示是否有文件
				$post['filename']=$info['name'];	//表示文件的原始名称
			}
			//补充字段from_id，addtime
			$post['from_id'] = session('id'); //发件人id
			$post['addtime'] =time();  //发送时间
			//数据的保存
			return $this->add($post);

		}
	}

}