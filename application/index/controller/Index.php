<?php
namespace app\index\controller;

class Index extends Common
{
    public function index()
    {
        $headConf = ['title'=>'hdphp教学博客-首页'];
        $this->assign('headConf',$headConf);

        $arcticleData = db('article')->alias('a')->join('__CATEGORY__ c ','c.cate_id= a.cate_id')->where('a.is_recycle',2)->order('sendtime desc')->select();
        foreach ($arcticleData as $k => $val) {
        	$arcticleData[$k]['tags'] = db('arc_tag')->alias('at')->join('__TAG__ t', 'at.tag_id = t.tag_id')->where('at.arc_id',$val['arc_id'])->field('t.tag_id,t.tag_name')->select();
        }

        $this->assign('arcticleData',$arcticleData);

        return $this->fetch();
    }
}
