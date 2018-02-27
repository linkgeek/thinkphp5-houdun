<?php

namespace app\admin\controller;

use think\Controller;

class Tag extends Controller
{
    protected $db;
    public function _initialize(){
    	parent::_initialize();
    	$this->db = new \app\common\model\Tag();
    }

    public function index(){
		$list = db('tag')->paginate(5);
		$this->assign('list', $list);

    	return $this->fetch();
    }

    /*
	* 添加 + 编辑
    */
    public function store(){
    	$tag_id = input('param.tag_id');
    	//halt($tag_id);

    	if(request()->isPost()){
    		//halt($_POST);
    		$res = $this->db->store(input('post.'));
    		if($res){
    			$this->success($res['msg'],'index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}

    	if($tag_id){
    		$oldData = $this->db->find($tag_id);
    		//halt($oldData);
    	}else{
    		$oldData = ['tag_name'=>''];
    	}
    	$this->assign('oldData',$oldData);
    	return $this->fetch();
    }

    /*
    * 删除
    */
    public function del(){
    	$tag_id = input('param.tag_id');
    	//halt($tag_id);
    	if(\app\common\model\Tag::destroy($tag_id)){
    		$this->success('删除成功！','index');exit;
    	}else{
    		$this->error('删除失败！');exit;
    	}
    }

}
