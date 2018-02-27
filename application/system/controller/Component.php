<?php

namespace app\system\controller;

use think\Controller;
use think\Request;

class Component extends Controller
{
    
    public function uploader()
    {
        //echo HD_ROOT;die;
        //var_dump($_FILES);

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                //dump($_POST);
                $data = [
                    'name'  => input('post.name'),
                    'filename'  => $info->getFilename(),
                    'path'  => 'uploads/'.$info->getSaveName(),
                    'extension'  => $info->getExtension(),
                    'createtime'  => time(),
                    'size'  => input('post.size'),
                ];

                //dump($data);die;
                db('attachment')->insert($data);
                echo json_encode(['valid'=>1,'message'=>HD_ROOT.'uploads/'.$info->getSaveName()]);
            }else{
                echo json_encode(['valid'=>o,'message'=>$file->getError()]);
            }
        }
    }

    public function filesLists(){
        //echo 1;die;

        $db = db('attachment')->whereIn('extension', explode(',',strtolower(input('post.extensions'))))->order('id desc');
        $res = $db->paginate(2);
        $data = [];
        if($res->toArray()){
            //dump($res->toArray());die;
            foreach ($res as $k => $v) {
                $data[$k]['createtime'] = date('Y-m-d',$v['createtime']);
                $data[$k]['size'] = $v['size'];
                $data[$k]['url'] = HD_ROOT.$v['path'];
                $data[$k]['path'] = HD_ROOT.$v['path'];
                $data[$k]['name'] = $v['name'];
            }
        }
        //dump($data);die;
        echo json_encode(['data'=>$data, 'page'=>$res->render()? :'']);
    }

}
