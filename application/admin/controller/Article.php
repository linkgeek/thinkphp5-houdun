<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Category;

class Article extends Controller
{
    protected $db;
    public function _initialize(){
        parent::_initialize();
        $this->db = new \app\common\model\Article();
    }

    public function index()
    {
        $field = $this->db->getAll(2);
        $this->assign('field',$field);
        //dump($field);
    	return $this->fetch();
    }

    /*添加文章*/
    public function store()
    {
    	if(request()->isPost()){
            $res = $this->db->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
                exit;
            }else{
                $this->error($res['msg']);
                exit;
            }
        }

        $cateData = (new Category())->getAll();
    	//halt($cateData);
    	$this->assign('cateData',$cateData);

    	$tagData = db('tag')->select();
    	$this->assign('tagData',$tagData);
    	return $this->fetch();
    }

    public function edit(){
        if(request()->isPost()){
            $res = $this->db->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }


        $arc_id = input('param.arc_id');
        //echo $arc_id;
        $cateData = (new Category())->getAll();
        //halt($cateData);
        $this->assign('cateData',$cateData);

        $oldData = db('article')->find($arc_id);
        $this->assign('oldData',$oldData);
        
        $tagData = db('tag')->select();
        $this->assign('tagData',$tagData);

        $tag_ids = db('arc_tag')->where('arc_id',$arc_id)->column('tag_id');
        $this->assign('tag_ids',$tag_ids);
        return $this->fetch();
    }

    /*改变排序*/
    public function changeSort(){
        if(request()->isAjax()){
            //dump($_POST);
            $res = $this->db->changeSort(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');
                exit;
            }else{
                $this->error($res['msg']);
                exit;
            }
        }
    }

    /*
     * 删除到回收站
    */
    public function delRecycle()
    {
        $arc_id = input('param.arc_id');
        if($this->db->save(['is_recycle'=>1],['arc_id'=>$arc_id])){
            $this->success('操作成功!','index');exit;
        }else{
            $this->error('操作失败！');exit;
        }
    }

    /*
     * 回收站列表
    */
    public function recycle()
    {
        $field = $this->db->getAll(1);
        $this->assign('field',$field);
        return $this->fetch();
    }

    /*
     * 回收站恢复
    */
    public function outRecycle()
    {
        $arc_id = input('param.arc_id');
        if($this->db->save(['is_recycle'=>2],['arc_id'=>$arc_id])){
            $this->success('操作成功!','index');exit;
        }else{
            $this->error('操作失败！');exit;
        }
    }

    /*
     * 彻底删除
    */
    public function del()
    {
        $arc_id = input('param.arc_id');
        $res = $this->db->del($arc_id);
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }
}
