<?php

namespace app\admin\controller;

use think\Controller;

class Webset extends Controller
{
    //
    public function index()
    {
    	$field = db('webset')->select();
    	$this->assign('field',$field);
    	return $this->fetch();
    }

    public function edit(){
    	if(request()->isAjax())
		{
			$res = (new \app\common\model\Webset())->edit(input('post.'));
			if($res['valid']){
				$this->success($res['msg'],'index');exit;
			}else{
				$this->error($res['msg']);exit;
			}
		}
    }
}
