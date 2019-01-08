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
        $banners = cache('banners_homepage');
        if (!$banners){
            $banners = Banner::limit(5)->order('id','desc')->select();
            cache('banners_homepage',$banners);
        }
        if (isMobile()){
            $newest = cache('newest_homepage_mobile');
            if (!$newest){
                $newest = $this->bookService->getBooks('create_time');
                cache('newest_homepage_mobile',$newest);
            }
            $hot = cache('hot_homepage_mobile');
            if (!$hot){
                $hot = $this->bookService->getBooks('click');
                cache('hot_homepage_mobile',$hot,60);
            }
            $ends = cache('ends_homepage_mobile');
            if (!$ends){
                $ends = $this->bookService->getBooks('update_time',[['end','=','1']]);
                cache('ends_homepage_mobile',$ends);
            }

        }else{
            $newest = cache('newest_homepage_pc');
            if (!$newest){
                $newest = $this->bookService->getBooks('create_time','1=1',10);
                cache('newest_homepage_pc',$newest);
            }
            $hot = cache('hot_homepage_pc');
            if (!$hot){
                $hot = $this->bookService->getBooks('click','1=1',10);
                cache('hot_homepage_pc',$hot,60);
            }
            $ends = cache('ends_homepage_pc');
            if (!$ends){
                $ends = $this->bookService->getBooks('update_time',[['end','=','1']],10);
                cache('ends',$ends);
            }

        }

        $rands = $this->bookService->getRandBooks();
        $this->assign([
            'banners' => $banners,
            'banners_count' => count($banners),
            'newest' => $newest,
            'hot' => $hot,
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

    public function bookshelf(){
        return view($this->tpl);
    }
}

