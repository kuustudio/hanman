<?php
/**
 * Created by PhpStorm.
 * User: zhangxiang
 * Date: 2018/12/10
 * Time: 9:26 PM
 */

namespace app\admin\controller;

use app\model\Chapter;
use app\model\Tags;
use think\facade\App;
use app\model\Book;
use think\facade\Log;
use app\model\Photo;

class Xqmanhua extends BaseAdmin
{
    protected $bookService;
    protected $tagsService;
    protected function initialize()
    {
        $this->tagsService = new \app\service\TagsService();
        $this->bookService = new \app\service\BookService();
    }

    public function getlist(){
        $json = json_decode(http("http://39.105.138.73/api/cate/all?chidu="),true);
        foreach ($json as $item){
            $this->getdetail($item['id']);
        }
        return '全部完成';
    }

    private function getdetail($id){
        $json = array();
        try{
            $json = json_decode(http("http://39.105.138.73/api/cate/view?id=".$id),true) ;
            $bookname = $json['data']['meta']['name'];
            $tags = $json['data']['content']['zuopin']['tag'];
            $desc = $json['data']['content']['zuopin']['desc'];
            $cover = '';
            if (array_key_exists('h',$json['data']['content']['zuopin'])){
                $cover = "http://cdn.xqmanhua.com".$json['data']['content']['zuopin']['h'];
            }
            $this->createbook($id,$bookname,$cover,$tags,$desc);
        }catch (Exception $e){
            Log::record($e->getMessage(),'error');
        }finally{

        }
    }

    private function createbook($id,$bookname,$cover,$tags,$desc){
        $book = $this->bookService->getByName($bookname);
        if ($book){
            if($book->end == 0){
                $this->crawlpics($id,$book->id);
            }
        }else{
            $book = new Book();
            $book->bookname = $bookname;
            $book->author_id = 1;
            $book->summary = $desc;
            $book->end = 1;
            if (!empty($tags)){
                $book->tags = $tags;
                $tags_arr = explode('|',$tags); //拆分标签成数组
                foreach ($tags_arr as $tagname) {
                    $tag = $this->tagsService->getByName($tagname);
                    if(is_null($tag) || empty($tag)){
                        Tags::Create(['tagname' => $tagname]); //如果数据库里没有该标签，则追加
                    }
                }
            }
            $book->save();
            $dir = App::getRootPath().'/public/static/upload/book/' . $book->id;
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $img_name = $dir.'/cover.jpg';
            $content = @file_get_contents($cover);
            file_put_contents($img_name,$content);
            $this->crawlpics($id,$book->id);
        }
    }

    public function crawlpics($id,$bookid){
        try{
            $json = json_decode(http("http://39.105.138.73/api/cate/view?id=".$id),true);
            foreach ($json['data']['list'] as $item){
                $chapter_name = $item['meta']['name'];
                $pics = $item['content']['doc']['pics'];
                $this->createchapter($bookid,$chapter_name,$pics);
            }
        }catch (Exception $e){
            Log::record($e->getMessage(),'error');
        }finally {

        }
    }

    private function createchapter($bookid,$chapter_name,$pics){
        $map[] = ['chapter_name','=',$chapter_name];
        $map[] = ['book_id','=',$bookid];
        $chapter = Chapter::where($map)->find();
        if ($chapter){
            Log::record('章节重复');
        }else{
            $chapter = new Chapter();
            $chapter->chapter_name = $chapter_name;
            $chapter->book_id = $bookid;
            $chapter->save();
            $this->savepics($bookid,$chapter->id,$pics);
        }
    }

    private function savepics($bookid,$chapter_id,$pics){
        foreach ($pics as $pic){
            $photo = new Photo();
            $photo->chapter_id = $chapter_id;
            $result = $photo->save();
            if ($result){
                $dir = App::getRootPath() . 'public/static/upload/book/'.$bookid.'/'.$chapter_id;
                if (!file_exists($dir)){
                    mkdir($dir,0777,true);
                }
                try{
                    $content = @file_get_contents("http://cdn.xqmanhua.com".$pic['img']);
                    file_put_contents($dir.'/'.$photo->id.'.jpg',$content);
                }catch (Exception $e){
                    Log::record($e->getMessage(),'error');
                }finally{

                }
            }
        }
    }
}