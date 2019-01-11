<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/10/6
 * Time: 20:44
 */

namespace app\admin\controller;

use app\model\Book;
use app\model\Chapter;
use app\model\Photo;
use think\Controller;
use think\facade\App;
use think\Request;

class Photos extends BaseAdmin
{
    public function index(){
        $chapter_id = input('chapter_id');
        $chapter = Chapter::get($chapter_id);
        $book_id = input('book_id');
        $book = Book::get($book_id);
        $photos = Photo::where('chapter_id','=',$chapter_id)
            ->order('id')->select();
        $this->assign([
            'photos'=>$photos,
            'chapter_id'=>$chapter_id,
            'book_id'=>$book_id,
            'book_name'=>$book->bookname,
            'chapter_name'=>$chapter->chapter_name
        ]);
        return view();
    }

    public function clear(){
        $chapter_id =  input('chapter_id');
        Photo::destroy(function ($query) use($chapter_id){
            $query->where('chapter_id','=',$chapter_id);
        });
        $this->success('删除章节图片');
    }

    public function delete(){
        $id = input('id');
        Photo::destroy($id);
        return ['err'=>0,'msg'=>'删除成功'];
    }

    public function upload(Request $request){
        $book_id = $request->post('book_id');
        if (is_null(Book::get($book_id))){
            $this->error('没有选择书籍');
        }
        $chapter_id = $request->post('chapter_id');
        if (is_null(Chapter::get($chapter_id))){
            $this->error('没有选择章节');
        }
        $files = $request->file('image');
        foreach($files as $file){
            $photo = new Photo();
            $photo->chapter_id = $chapter_id;
            $result = $photo->save();
            if ($result){
                $dir = App::getRootPath() . 'public/static/upload/book/'.$book_id.'/'.$chapter_id;
                if (!file_exists($dir)){
                    mkdir($dir,0777,true);
                }
                $file->validate(['size'=>2048000,'ext'=>'jpg,png,gif'])->move($dir,$photo->id.'.jpg');
            }
        }
        $this->success('上传成功');
    }
}