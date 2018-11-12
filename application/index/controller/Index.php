<?php
namespace app\index\controller;

use app\model\Banner;
use think\Request;

class Index extends Base
{
    protected $bookService;
    protected function initialize()
    {
        $this->bookService = new \app\service\BookService();
    }

    public function index()
    {
        $banners = Banner::limit(5)->order('id','desc')->select();
        if (isMobile()){
            $updates = $this->bookService->getBooks('update_time');
            $newest = $this->bookService->getBooks('id');
            $ends = $this->bookService->getBooks('update_time',[['end','=','1']]);
        }else{
            $updates = $this->bookService->getBooks('update_time','1=1',10);
            $newest = $this->bookService->getBooks('id','1=1',10);
            $ends = $this->bookService->getBooks('update_time',[['end','=','1']],10);
        }

        $rands = $this->bookService->getRandBooks();
        $this->assign([
            'banners' => $banners,
            'banners_count' => count($banners),
            'updates' => $updates,
            'newest' => $newest,
            'ends' => $ends,
            'rands' => $rands
        ]);
        if (!isMobile()){
            $tags = \app\model\Tags::all();
            $this->assign('tags',$tags);
        }
        return view($this->tpl);
    }

    public function search(Request $request){
        $keyword = $request->param('keyword');
        $books = $this->bookService->getPagedBooks('id',[['bookname','like','%'.$keyword.'%']]);
        $this->assign('books',$books);
        return view($this->tpl);
    }

    public function history(){
        return view();
    }

    public function vip(Request $request){
        if ($request->isPost()){
            $vip_code = strtolower($request->param('vip_code'));
            cookie('vip',$vip_code);
            $this->success('您已经是vip了，请回网站继续浏览',url("index/history"));
        }
        return view();
    }
}

