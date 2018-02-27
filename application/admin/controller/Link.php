<?php

namespace app\admin\controller;

use think\Controller;

class Link extends Controller
{
    protected $db;
    public function _initialize(){
    	parent::_initialize();
    	$this->db = new \app\common\model\Link();
    }

    public function index()
    {
    	$field = $this->db->getAll();
    	$this->assign('field',$field);
    	return $this->fetch();
    }

    /*添加+编辑*/
    public function store()
    {
    	$link_id = input('param.link_id');
    	if(request()->isPost()){
    		$res = $this->db->store(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}

    	if($link_id){
    		$oldData = $this->db->find($link_id);
    	}else{
    		$oldData = ['link_name'=>'','link_url'=>'','link_sort'=>100];
    	}
    	$this->assign('oldData',$oldData);
    	return $this->fetch();
    }

    public function del(){
    	$link_id = input('param.link_id');
    	if(\app\common\model\Link::destroy($link_id)){
    		$this->success('删除成功！','index');exit;
    	}else{
    		$this->error('删除失败！');exit;
    	}
    }
}
