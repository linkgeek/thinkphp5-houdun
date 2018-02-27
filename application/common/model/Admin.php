<?php

namespace app\common\model;

use houdunwang\crypt\Crypt;
use think\Loader;
use think\Model;
use think\Validate;

class Admin extends Model
{
    //
    protected $pk = 'uid';//主键
    //设置当前模型对应的完整数据表名称
	protected $table = 'blog_admin';

	/*登录*/
	public function login($data)
	{
		//halt($data);

		//1.执行验证
		$validate = Loader::validate('Admin');
		//如果验证不通过
		if(!$validate->check($data)){
			//dump($validate->getError());
			return ['valid'=>0, 'msg'=>$validate->getError()];
		}
		//2.比对用户名和密码是否正确
		$userInfo = $this->where('username', $data['username'])->where('password',Crypt::encrypt($data['password']))->find();
		//halt($userInfo);

		if(!$userInfo){
			return ['valid'=>0,'msg'=>'用户名或者密码不正确'];
		}

		//3.将用户信息存入到session中
		session('admin.uid', $userInfo['uid']);
		session('admin.username', $userInfo['username']);
		return ['valid'=>1, 'msg'=>'登录成功'];
	}

	/**
	 * 修改密码
	 * @param $data post数据
	 */
	public function pass($data)
	{
		//1.执行验证
		$validate = new Validate([
		    'admin_password'  => 'require',
		    'new_password' => 'require',
		    'confirm_password' => 'require|confirm:new_password'
		],[
			'admin_password.require' => '请输入原始密码',
			'new_password.require' => '请输入新密码',
			'confirm_password.require' => '请输入确认密码',
			'confirm_password.confirm' => '确认密码跟新密码不一致',
		]);

		if (!$validate->check($data)) {
			return ['valid'=>0, 'msg'=>$validate->getError()];
		    //dump($validate->getError());
		}

		//2.原始是否正确
		$userInfo = $this->where('uid',session('admin.uid'))->where('password',Crypt::encrypt($data['admin_password']))->find();
		if(!$userInfo){
			return ['valid'=>0, 'msg'=> '原始密码不正确'];
		}

		//3.修改密码
		$res = $this->save([
		    'password'  => Crypt::encrypt($data['new_password']),
		],[$this->pk => session('admin.uid')]);
		if($res){
			return ['valid'=>1, 'msg'=> '密码修改成功'];
		}else{
			return ['valid'=>0, 'msg'=> '修改密码失败'];
		}
	}

}
