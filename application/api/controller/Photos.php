<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/11/9
 * Time: 21:22
 */

namespace app\api\controller;


use app\model\Photo;
use think\Controller;
use think\Request;

class Photos extends Controller
{
    public function save(Request $request){
        if ($request->isPost()){
            $chapter_id = $request->post('chapter_id');
            $pic = new Photo();
            $pic->save(['chapter_id'=>$chapter_id]);
            return $pic->id;
        }
        return '图片api';
    }
}