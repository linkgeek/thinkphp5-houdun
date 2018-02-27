<?php

namespace app\common\model;

use think\Model;
use houdunwang\arr\Arr;

class Category extends Model
{
    protected $pk = 'cate_id';
    protected $table = 'blog_category';

    public function getAll(){
    	return Arr::tree(db('category')->order('cate_sort desc,cate_id')->select(), 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
    }
    
    //添加
    public function store($data)
    {
    	//执行验证

		//执行添加
		$result = $this->validate(true)->save($data);
		if($result === false){
			return ['valid'=>0, 'msg'=>$this->getError()];
			//dump($this->getError());
		}else{
			return ['valid'=>1,'msg'=>'添加成功'];
		}
    }
    /*
    * 处理栏目分类
    */
    public function getCateData($cate_id){
        //找到子集
        $cate_ids = $this->getSon(db('category')->select(),$cate_id);
        //halt($cate_ids);
        //自己加进去
        $cate_ids[] = $cate_id;
        //排除以上
        //dump($cate_ids);
        $field = db('category')->whereNotIn('cate_id',$cate_ids)->select();
        return Arr::tree($field, 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
    } 
    /*
    * 子集
    */
    public function getSon($data,$cate_id){
        static $temp = [];
        foreach ($data as $key => $v) {
            if($cate_id == $v['cate_pid']){
                $temp[] = $v['cate_id'];
                $this->getSon($data,$v['cate_id']);
            }
        }
        return $temp;
    }

    /*
    * 编辑
    */
    public function edit($data){
        $result = $this->validate(true)->save($data,[$this->pk=>$data['cate_id']]);
        if($result){
            return ['valid'=>1, 'msg'=>'编辑成功！'];
        }else{
            return ['valid'=>0, 'msg'=>$this->getError()];
        }
    }

    /*
    * 删除
    */
    public function del($cate_id){
        
        //cate_pid
        $cate_pid = $this->where('cate_id',$cate_id)->value('cate_pid');
        //halt($cate_pid);

        //
        $this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);

        //
        if(Category::destroy($cate_id)){
            return ['valid'=>1,'msg'=>'删除成功！'];
        }else{
            return ['valid'=>0,'msg'=>'删除失败！'];
        }
    }
}
