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

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $author = Author::get($id);
        $this->assign('author',$author);
        return view();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $result = Author::update($request->param());
        if ($result){
            $this->success('编辑成功','index','',1);
        }else{
            $this->error('编辑失败');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
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
