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

    public function clearCache(){
        clearCache();
        $this->success('清理缓存','index','',1);
    }

    public function xiongzhang(){
        if ($this->request->isPost()){
            $urls = [];
            $start = input('start');
            $end = input('end');
            for ($i = $start;$i <= $end; $i++){
                array_push($urls,config('site.url').'/index/books/index/id/'.$i.'.html') ;
            }
            $result = xiongzhang_push($urls);
            $this->success($result);
        }
        return view();
    }
}
