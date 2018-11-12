<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/11/9
 * Time: 20:45
 */

namespace app\api\controller;


use think\Controller;
use think\Request;
use app\model\Chapter;

class Chapters extends Controller
{
    public function save(Request $request){
        if ($request->isPost()){
            $data = $request->param();

            if(empty($data['chapter_name'])){
                return json(['chapter_id' => -1]);
            }
            if (empty($data['book_id'])){
                return json(['chapter_id' => -1]);
            }
            $map[] = ['chapter_name','=',$data['chapter_name']];
            $map[] = ['book_id','=',$data['book_id']];
            $chapter = Chapter::where($map)->find();
            if ($chapter){
                return json(['chapter_id' => 0]);
            }
            $result = Chapter::create($data);
            return json($result);
        }
       return '章节api接口';
    }
}