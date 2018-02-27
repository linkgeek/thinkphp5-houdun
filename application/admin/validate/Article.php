<?php
namespace app\admin\validate;

use think\Validate;

/**
* 
*/
class Article extends Validate
{
	protected $rule = [
		'arc_title'=>'require',
		'arc_author'=>'require',
		'arc_sort'=>'require|number|between:1,9999',
		'cate_id'=>'notIn:0',
		'arc_thumb'=>'require',
		'arc_content'=>'require',
		'arc_digest'=>'require'
	];
	protected $message = [
		'arc_title.require'=>'请填写文章标题',
		'arc_sort.require'=>'请输入排序',
		'arc_sort.number'=>'排序必须为数字',
		'arc_sort.between'=>'排序需要在1-9999之间',
		'cate_id.notIn'=>'请选择'
	];
}