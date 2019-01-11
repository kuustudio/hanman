<?php

namespace app\admin\controller;

use app\model\Book;
use think\Controller;
use think\Request;
use app\model\Chapter;

class Chapters extends BaseAdmin
{
    protected $chapterService;

    public function initialize()
    {
        $this->chapterService = new \app\service\ChapterService();
    }

    public function index($book_id)
    {
        $book = Book::get($book_id);
        $data = $this->chapterService->getChapters([
            ['book_id','=',$book_id]
        ]);
        $this->assign([
            'chapters' => $data['chapters'],
            'count' => $data['count'],
            'book' => $book
        ]);
        return view();
    }


    public function save(Request $request)
    {
        $data = $request->param();
        if(empty($data['chapter_name'])){
            $this->error('没有填写章节名');
        }
        $map[] = ['chapter_name','=',$data['chapter_name']];
        $map[] = ['book_id','=',$data['book_id']];
        $chapter = Chapter::where($map)->find();
        if ($chapter){
            $this->error('存在同名章节');
        }
        $result = Chapter::create($data);
        if ($result){
            $param = [
                "id" => $data["book_id"],
                "update_time" => date("Y-m-d H:i:s", time())
            ];
            Book::update($param);

            $this->success('新增成功');
        }else{
            $this->error('新增失败');
        }
    }

    public function edit($id)
    {
        $returnUrl = input('returnUrl');
        $id = input('id');
        $chapter = Chapter::get($id);
        if (!$chapter){
            $this->error('不存在的章节');
        }
        $this->assign([
            'chapter' => $chapter,
            'returnUrl' => $returnUrl
        ]);
        return view();
    }

    public function update()
    {
        $returnUrl = input('returnUrl');
        $id = input('id');
        $chapter_name = input('chapter_name');
        $chapter = Chapter::get($id);
        if ($chapter){
            $chapter->chapter_name = $chapter_name;
            $chapter->save();
            $this->success('编辑成功',$returnUrl,'',1);
        }else{
            $this->error('章节不存在');
        }
    }

    public function delete($id)
    {
        $chapter = Chapter::get($id);
        $photos = $chapter->photos;
        if (count($photos) > 0){
            return ['err'=>1,'msg'=>'章节下还存在图片，请先删除'];
        }
        $chapter->delete();
        return ['err'=>0,'msg'=>'删除成功'];
    }
}
