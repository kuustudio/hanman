<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/12/26
 * Time: 11:26
 */

namespace app\admin\controller;

use app\model\Chapter;
use think\facade\App;
use app\model\Photo;
use Requests;

class Suefe extends BaseAdmin
{
    protected $bookService;
    protected $tagsService;

    protected function initialize()
    {
        $this->tagsService = new \app\service\TagsService();
        $this->bookService = new \app\service\BookService();
        set_time_limit(-1);
    }

    public function index()
    {
        return view();
    }

    public function save()
    {
        $book_id = input('book_id');
        $start = input('start');
        $end = input('end');
        $admin_book_id = input('admin_book_id');
        for ($i = $start; $i <= $end; $i++) {
            $jpgurl = "http://img.chunfeifs.com/xs/" . $book_id . "/" . $i . "/";
            $chapter = new Chapter();
            $chapter->chapter_name = $i;
            $chapter->book_id = $admin_book_id;
            $chapter->save();
            $x = 1;
            $arr = array();
            do {
                $get = $jpgurl . $x . ".jpeg";
                $x++;
                $arr[] = $get;
            } while ($this->url_exists($get) == true);
            array_pop($arr);
            $this->savepic($admin_book_id, $chapter->id, $arr);
        }
    }

    private function savepic($bookid, $chapter_id, $arr)
    {
        $dir = App::getRootPath() . 'public/static/upload/book/' . $bookid . '/' . $chapter_id;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        try {
            foreach ($arr as $url) {
                $photo = new Photo();
                $photo->chapter_id = $chapter_id;
                $photo->save();
                $content = @file_get_contents($url);
                file_put_contents($dir . '/' . $photo->id . '.jpg', $content);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {

        }
    }

    function url_exists($url)
    {
        $request = Requests::get($url);
        if ($request->status_code == 200) {
            return true;
        } else {
            return false;
        }
    }
}