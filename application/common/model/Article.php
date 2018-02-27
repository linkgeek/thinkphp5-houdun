<?php

namespace app\common\model;

use think\Model;

class Article extends Model
{
    protected $pk = 'arc_id';
    protected $table = 'blog_article';

    protected $auto = ['admin_id'];
    protected $insert = ['sendtime'];  
    protected $update = ['updatetime'];  
    
    protected function setAdminIdAttr()
    {
        return session('admin.uid');
    }
    protected function setSendTimeAttr()
    {
        return time();
    }
    protected function setUpdateTimeAttr()
    {
        return time();
    }

    /*文章首页列表*/
    public function getAll($is_recycle){
    	return db('article')->alias('a')
    			->join('category c','a.cate_id = c.cate_id')
    			->order('a.arc_sort desc,a.sendtime desc,a.arc_id desc')
    			->where('is_recycle',$is_recycle)
    			->field('a.arc_id,a.arc_title,a.arc_author,a.arc_sort,c.cate_name,a.sendtime')
    			->paginate(2);
    }

    /*添加文章*/
    public function store($data){
    	//halt($data);
    	if(!isset($data['tag'])){
    		return ['valid'=>0,'msg'=>'请选择标签'];
    	}

    	$result = $this->validate(true)->allowField(true)->save($data);
    	if($result){

    		//标签添加
    		foreach ($data['tag'] as $v) {
    			$arcTag = [
    				'arc_id'=>$this->arc_id,
    				'tag_id'=>$v,
    			];
    			(new ArcTag())->save($arcTag);
    		}

    		return ['valid'=>1,'msg'=>'添加成功'];
    	}else{
    		return ['valid'=>0,'msg'=>$this->getError()];
    	}
    }

    /*
    * 编辑文章
    */
    public function edit($data){
    	//halt($data);
    	$result = $this->validate(true)->allowField(true)->save($data,[$this->pk=>$data['arc_id']]);
    	if($result){
    		//标签操作
    		//先删除
    		(new ArcTag())->where('arc_id',$data['arc_id'])->delete();
    		//再添加
    		//标签添加
    		foreach ($data['tag'] as $v) {
    			$arcTag = [
    				'arc_id'=>$this->arc_id,
    				'tag_id'=>$v,
    			];
    			(new ArcTag())->save($arcTag);
    		}

    		return ['valid'=>1,'msg'=>'编辑成功！'];
    	}else{
    		return ['valid'=>0,'msg'=>$this->getError()];
    	}
    }

    /*改变排序*/
    public function changeSort($data){
    	//halt($data);
    	$result = $this->validate([
    		'arc_sort'=>'require|between:1,9999'
		],[
			'arc_sort.require'=>'请输入排序',
			'arc_sort.between'=>'排序在1-9999之间'
		])->save($data,[$this->pk=>$data['arc_id']]);

		if($result){
			return ['valid'=>1,'msg'=>'操作成功'];
		}else{
			return ['valid'=>0,'msg'=>$this->getError()];
		}
    }

    /*
    * 删除回收站
    */
    public function del($arc_id){
    	if(Article::destroy($arc_id)){
    		//删除标签
    		(new ArcTag())->where('arc_id',$arc_id)->delete();
    		return ['valid'=>1,'msg'=>'操作成功！'];
    	}else{
    		return ['valid'=>0,'msg'=>'操作失败！'];
    	}
    }
}
