<?php

namespace app\index\controller;

use app\model\Book;
use think\Db;
use think\facade\Cache;
use think\Request;

class Books extends Base
{
    protected $bookService;

    public function initialize()
    {
        cookie('nav_switch', 'booklist'); //设置导航菜单active
        $this->bookService = new \app\service\BookService();
    }

    public function index(Request $request)
    {
        $id = $request->param('id');
        $book = Cache::get('book' . $id);
        $tags = Cache::get('book' . $id . 'tags');
        if ($book ==false) {
            $book = Book::with('chapters,author')->find($id);
            $tags = explode('|', $book->tags);
            Cache::set('book' . $id, $book);
            Cache::set('book' . $id . 'tags', $tags);
        }
        $book->click = $book->click + 1;
        $book->isUpdate(true)->save();
        $recommand = $this->bookService->getRandBooks();
        $start = Cache::get('book_start' . $id);
        if ($start == false) {
            $db = Db::query('SELECT id FROM chapter WHERE book_id = ' . $request->param('id') . ' ORDER BY id LIMIT 1');
            $start = $db ? $db[0]['id'] : -1;
            Cache::set('book_start' . $id, $start);
        }

        $this->assign([
            'book' => $book,
            'tags' => $tags,
            'recommand' => $recommand,
            'start' => $start,
            'title' => $book->bookname.'无修在线阅读',
            'des' => $book->summary
        ]);
        if (!isMobile()){
            $updates = $this->bookService->getBooks('update_time',[],10);
            $this->assign('updates',$updates);
        }
        return view($this->tpl);

    }

    public function booklist(Request $request)
    {
        $tag = $request->param('tag');
        if (is_null($tag)){
            $tag = '全部';
            $books = $this->bookService->getPagedBooks('update_time',[],28);
        }else{
            $map[] = ['tags', 'like', '%' . $tag . '%'];
            $books = $this->bookService->getPagedBooks('update_time', $map, 28);
        }

        $this->assign([
            'books' => $books,
            //'menus' => $menus,
            'title' => '韩漫列表',
            'tag' => $tag
        ]);
        if (!isMobile()){
            $tags = \app\model\Tags::all();
            $this->assign([
                'tags' => $tags,
                'param' => $tag
            ]);
        }
        return view($this->tpl);
    }
}
