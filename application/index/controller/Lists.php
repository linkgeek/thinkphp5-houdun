<?php

namespace app\index\controller;

use app\common\model\Category;

class Lists extends Common
{
    public function index()
    {
        $headConf = ['title'=>'hdphp教学博客-列表页'];
        $this->assign('headConf',$headConf);

        $cate_id = input('param.cate_id');
        $tag_id = input('param.tag_id');

        //halt($cate_id);
        if($cate_id){
        	$cids = (new Category())->getSon(db('category')->select(),$cate_id);
        	$cids[] = $cate_id;
        	$headData = [
        		'title'=> '分类',
        		'name'=>db('category')->where('cate_id',$cate_id)->value('cate_name'),
        		'total'=>db('article')->whereIn('cate_id',$cids)->count(),
        	];

        	//获取文章数据
        	$articleData = db('article')->alias('a')
        		->join('__CATEGORY__ c','c.cate_id = a.cate_id')->where('a.is_recycle',2)->whereIn('a.cate_id',$cids)->select();
        }

        if($tag_id){
        	$headData = [
        		'title'=> '标签',
        		'name'=>db('tag')->where('tag_id',$tag_id)->value('tag_name'),
        		'total'=>db('arc_tag')->where('tag_id',$tag_id)->count(),
        	];

        	//获取文章数据
        	$articleData = db('article')->alias('a')
        		->join('__CATEGORY__ c','c.cate_id = a.cate_id')
        		->join('__ARC_TAG__ at','at.arc_id=a.arc_id')->where('a.is_recycle',2)->where('at.tag_id',$tag_id)->select();   		
        }

        foreach ($articleData as $k => $val) {
        	$articleData[$k]['tags'] = db('arc_tag')->alias('at')->join('__TAG__ t', 'at.tag_id = t.tag_id')->where('at.arc_id',$val['arc_id'])->field('t.tag_id,t.tag_name')->select();
        }

        $this->assign('headData',$headData);
        $this->assign('articleData',$articleData);
        return $this->fetch();
    }
}
