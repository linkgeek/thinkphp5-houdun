<?php

namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    protected $db;
    protected function _initialize()
    {
    	parent::_initialize();
    	$this->db = new \app\common\model\Category();
    }

    public function index()
    {
    	//$field = db('category')->select();
        $field = $this->db->getAll();
        //halt($field);
    	$this->assign('field',$field);
    	return $this->fetch();
    }

    //添加顶级
    public function store()
    {
    	if(request()->isPost()){
    		
    		//halt(input('post.'));
    		$res = $this->db->store(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}
    	return $this->fetch();
    }

    /**
	 * 添加子栏目
	*/
    public function addSon()
    {
    	if(request()->isPost()){
    		$res = $this->db->store(input('post.'));
    		if($res['valid']){
    			$this->success($res['msg'],'index');exit;
    		}else{
    			$this->error($res['msg']);exit;
    		}
    	}

    	$cate_id = input('param.cate_id');
    	$cat = $this->db->where('cate_id',$cate_id)->find();
    	$this->assign('cat',$cat);
    	//halt($cate_id);
    	return $this->fetch();
    }

    /**
     * 栏目编辑
    */
    public function edit(){

        if(request()->isPost()){
            //halt($_POST);
            $res = $this->db->edit(input('post.'));
            if($res){
                $this->success($res['msg'], 'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $cate_id = input('param.cate_id');
        $oldData = $this->db->find($cate_id);
        $this->assign('oldData', $oldData);
        $cateData = $this->db->getCateData($cate_id);
        //halt($cateData);
        $this->assign('cateData', $cateData);
        return $this->fetch();
    }

    /**
     * 栏目删除
    */
    public function del($cate_id){
        //halt($cate_id);
        $res = $this->db->del($cate_id);
        if($res){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }
}
