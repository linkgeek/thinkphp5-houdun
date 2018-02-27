<?php

namespace app\admin\controller;

use app\common\model\Admin;
use houdunwang\crypt\Crypt;
use think\Controller;
use think\Request;

class Login extends Controller
{
    public function login()
    {
    	
    	/*$res = db('admin')->find(1);
    	dump($res);*/
    	//echo Crypt::encrypt('123'); //加密 h3vPU8JGuF3VS/uxIpjRSw==
    	//echo Crypt::decrypt('h3vPU8JGuF3VS/uxIpjRSw=='); //解密  admin888

    	if(request()->isPost()){
    		$res = (new Admin())->login(input('post.'));
    		if($res['valid']){
    			//说明登录成功
				$this->success($res['msg'],'admin/entry/index');exit;
    		}else{
    			//说明登录失败
				$this->error($res['msg']);exit;
    		}
    	}
    	return $this->fetch('index');
    }

    public function logout(){
        session(null);
        $this->redirect('login/login');
    }
}
