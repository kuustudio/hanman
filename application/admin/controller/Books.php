<?php

namespace app\admin\controller;

use app\model\Book;
use think\facade\App;
use think\Request;
use app\model\Tags;

class Books extends BaseAdmin
{
    protected $authorService;
    protected $bookService;
    protected $tagsService;

    public function initialize()
    {
        $this->authorService = new \app\service\AuthorService();
        $this->bookService = new \app\service\BookService();
        $this->tagsService = new \app\service\TagsService();
    }

    public function index()
    {
        $data = $this->bookService->getPagedBooksAdmin();
        $books = $data['books'];
        foreach ($books as &$book) {
            $book['chapter_count'] = count($book->chapters);
        }
        $count = $data['count'];
        $this->assign([
            'books' => $books,
            'count' => $count
            ]);
        return view();
    }

    public function search(){
        $name = input('bookname');
        $where = [
            ['bookname', 'like', '%'.$name.'%']
        ];
        $data = $this->bookService->getPagedBooksAdmin($where);
        $books = $data['books'];
        foreach ($books as &$book) {
            $book['chapter_count'] = count($book->chapters);
        }
        $count = $data['count'];
        $this->assign([
            'books' => $books,
            'count' => $count
        ]);
        return view('index');
    }

    public function create()
    {
        return view();
    }

    public function save(Request $request)
    {
        $book = new Book();
        $data = $request->param();
        $validate = new \app\admin\validate\Book();
        if ($validate->check($data)){
            if ($this->bookService->getByName($data['bookname'])){
                $this->error('漫画名已经存在');
            }

            //作者处理
            $author = $this->authorService->getByName($data['author']);
            if (is_null($author)){//如果作者不存在
                $author = new \app\model\Author();
                $author->author_name = $data['author'];
                $author->save();
            }
            $book->author_id = $author->id;
            $book->bookname = $data['bookname'];
            $result = $book->save($data);
            if ($result){
                //标签处理
                if (!empty($data['tags'])){
                    $tags = explode('|',$data['tags']); //拆分标签成数组
                    foreach ($tags as $tagname) {
                        $tag = $this->tagsService->getByName($tagname);
                        if(is_null($tag) || empty($tag)){
                            Tags::Create(['tagname' => $tagname]); //如果数据库里没有该标签，则追加
                        }
                    }
                }
                $dir = App::getRootPath().'/public/static/upload/book/' . $book->id;
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $cover = $request->file('cover');
                if ($cover) {
                    $cover->validate(['size' => 1024000, 'ext' => 'jpg,png,gif'])
                        ->move($dir,'cover.jpg');
                }

                $this->success('添加成功','index','',1);
            }else{
                $this->error('添加失败');
            }

        }else{
            $this->error($validate->getError());
        }
    }

    public function edit($id)
    {
        $book = Book::with('author')->find($id);
        $this->assign('book',$book);
        return view();
    }

    public function update(Request $request){
        $data = $request->param();
        $validate = new \app\admin\validate\Book();
        if ($validate->check($data)){
            //作者处理
            $author = $this->authorService->getByName($data['author']);
            if (is_null($author)){//如果是新作者
                $author = new \app\model\Author();
                $author->author_name = $data['author'];
                $author->save();
            }else{ //如果作者已经存在
                $data['author_id'] = $author->id;
            }
            $result = Book::update($data);
            if ($result){
                //标签处理
                if (!empty($data['tags'])){
                    $tags = explode('|',$data['tags']); //拆分标签成数组
                    foreach ($tags as $tagname) {
                        $tag = $this->tagsService->getByName($tagname);
                        if (is_null($tag) || empty($tag)){
                            Tags::create(['tagname' => $tagname]); //如果数据库里没有该标签，则追加
                        }
                    }
                }
                $dir = App::getRootPath().'/public/static/upload/book/' . $data['id'];
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $cover = $request->file('cover');
                if ($cover) {
                    $cover->validate(['size' => 1024000, 'ext' => 'jpg,png,gif'])
                        ->move($dir,'cover.jpg');
                    //清理浏览器缓存
                    header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
                    header("Cache-Control: no-cache, must-revalidate" );
                }
                $this->success('修改成功','index','',1);
            }else{
                $this->error('修改失败');
            }

        }else{
            $this->error($validate->getError());
        }
    }

    public function delete($id)
    {
        $book = Book::get($id);
        $chapters = $book->chapters;
        if (count($chapters) > 0){
            return ['err' => 1,'msg' => '该漫画下含有章节，请先删除所有章节'];
        }
        $book->delete();
        return ['err' => 0,'msg' => '删除成功'];
    }


}
