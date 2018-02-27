<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Common extends Controller
{
    public function __construct( Request $request = null)
    {
    	parent::__construct( $request );

    	//1.配置项
    	$webset = $this->loadWebSet();
    	$this->assign('_webset',$webset);
    	//2.顶级栏目
    	$cateData = $this->loadCateData();
    	$this->assign('_cateData',$cateData);
    	//3.全部栏目
    	$allCateData = $this->loadAllCateData();
    	$this->assign('_allCateData',$allCateData);
    	//4.标签
    	$tagData = $this->loadTagData();
    	$this->assign('_tagData',$tagData);
    	//5.
    	$articleData = $this->loadArticleData();
    	$this->assign('_articleData',$articleData);
    	//6.
    	$linkData = $this->loadLinkData();
    	$this->assign('_linkData',$linkData);
    }

    private function loadLinkData()
    {
    	return db('link')->order('link_sort desc')->select();
    }

    private function loadArticleData()
    {
    	return db('article')->field('arc_id,arc_title,sendtime')->order('sendtime desc')->limit(2)->select();
    }

    private function loadWebSet()
    {
    	return db('webset')->column('webset_value','webset_name');
    }

    private function loadCateData()
    {
    	return db('category')->where('cate_pid',0)->order('cate_sort desc')->limit(3)->select();
    }

    private function loadAllCateData()
    {
    	return db('category')->order('cate_sort desc')->select();
    }

    private function loadTagData()
    {
    	return db('tag')->order('tag_id desc')->select();
    }
}
