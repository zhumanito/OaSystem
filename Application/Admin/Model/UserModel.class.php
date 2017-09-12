<?php
//声明命名空间
namespace Admin\Model;
//引入父类
use Think\Model;
//声明一个类并继承父类
class UserModel extends Model
{
	protected $insertFields ='username,password,truename,nickname,dept_id,sex,birthday,tel,email,remark';//新增数据时允许写入的字段
	protected $updateFields	='id,username,password,truename,nickname,dept_id,sex,birthday,tel,email,remark';//更新数据时允许写入的字段
	protected $_validate = array(
            array('username','require','用户名不能为空!',1,'regex',3),
            array('username','1,30','用户名长度为1—30个字符!',1,'length',3),
            array('password','require','密码不能为空!'),
            array('truename','require','不能为真实姓名不为空!',1,'regex',3),
            array('nickname','require','昵称不能为空!',1,'regex',3),
            array('dept_id','require','所属部门不能为空!',1,'regex',3),
            array('sex','require','性别不能为空!',1,'regex',3),
            array('birthday','require','生日不能为空!',1,'regex',3),
            array('tel','require','电话不能为空!',1,'regex',3),
            array('tel','1,13','电话长度不超过11位!',1,'length',3),
            array('email','email','邮箱不能为空!',1,'regex',3),
	);


	protected function _before_insert(&$data, $options) 
        {
            $data['addtime'] = time();
        }
}