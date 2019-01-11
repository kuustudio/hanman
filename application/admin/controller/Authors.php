<?php

namespace app\admin\controller;

use app\model\Author;
use think\Controller;
use think\Request;

class Authors extends BaseAdmin
{
    protected $authorService;

    public function initialize()
    {
        $this->authorService = new \app\service\AuthorService();
    }

    public function index()
    {
        $data = $this->authorService->getAuthors();
        $this->assign([
            'authors' => $data['authors'],
            'count' => $data['count']
        ]);
        return view();
    }

    public function getBooksByAuthor($author_name){
        $data = $this->authorService->getBooksByAuthor($author_name); //查出书籍
        $this->assign([
            'books' => $data['books'],
            'count' => count($data['books'])
        ]);
        return view('books/index');
    }

    public function search($author_name){
        $data = $this->authorService->getAuthors([
            ['author_name','like','%'.$author_name.'%']
        ]);
        $this->assign([
            'authors' => $data['authors'],
            'count' => $data['count']
        ]);
        return view('index');
    }

    public function create(){
        return view();
    }

    public function save(){
        $author_name = input('author_name');
        $author = new Author();
        $author->author_name = $author_name;
        $author->save();
        $this->success('作者新增成功',url('authors/index'),'',1);
    }

    public function edit($id)
    {
        $returnUrl = input('returnUrl');
        $author = Author::get($id);
        $this->assign([
            'author' => $author,
            'returnUrl' => $returnUrl
        ]);
        return view();
    }

    public function update(Request $request, $id)
    {
        $data = $request->param();
        $returnUrl = $data['returnUrl'];
        $result = Author::update($data);
        if ($result){
            $this->success('编辑成功',$returnUrl,'',1);
        }else{
            $this->error('编辑失败');
        }
    }

    public function delete($id)
    {
        $author = Author::get($id);
        $books = $author->books;
        if (count($books) > 0){
            return json_encode(['err' => '1','msg' => '该作者名下还有作品，请先删除所有作品']);
        }
        $author->delete();
        return json_encode(['err' => '0','msg' => '删除成功']);
    }
}
