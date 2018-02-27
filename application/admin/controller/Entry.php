<?php

namespace app\admin\controller;

use app\common\model\Admin;

class Entry extends Common
{
    public function index()
    {
    	return $this->fetch();
    }

    /**
	 * 修改密码
	 */
    public function pass()
    {
    	if(request()->isPost()){
    		$res = (new Admin())->pass(input('post.'));
    		if($res['valid']){
    			session(null);
    			$this->success($res['msg'],'admin/entry/index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}
    	return $this->fetch();
    }
}
