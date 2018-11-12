<?php
/**
 * Created by PhpStorm.
 * User: zhangxiang
 * Date: 2018/10/17
 * Time: 下午5:01
 */

namespace app\index\controller;


use think\Controller;
use app\model\Tags as Tag;
use think\facade\Cache;

class Tags extends Base
{
    public function index(){
        $tags = Cache::get('tags');
        if (!$tags){
            $tags = Tag::all();
            Cache::set('tags',$tags,600);
        }
        $this->assign([
            'tags' => $tags,
            'title' => '韩漫分类'
        ]);


        return view();
    }
}