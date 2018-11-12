<?php

namespace app\admin\controller;

use app\model\Book;
use think\Controller;

class Index extends BaseAdmin
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $site_name = config('site.site_name');
        $url = config('site.url');
        $admin = config('site.admin');
        $this->assign([
            'site_name' => $site_name,
            'url' => $url,
            'admin' => $admin
        ]);
        return view();
    }

    public function test(){
        return get_vip_code();
    }

    public function setvip(){
        $books = Book::all();
        foreach ($books as $book){
            $i = 0;
            foreach ($book->chapters as $chapter){
                if ($i > config('site.vip_count')){
                    $chapter->isvip = 1;
                    $chapter->isupdate(true)->save();
                }
                $i++;
            }
        }
    }

    public function clearCache(){
        clearCache();
        $this->success('清理缓存','index','',1);
    }
}
