<?php
/**
 * Created by PhpStorm.
 * User: zhangxiang
 * Date: 2018/10/18
 * Time: 下午5:42
 */

namespace app\index\controller;

use app\model\Chapter;
use think\Db;
use think\facade\Cache;

class Chapters extends Base
{
    public function index($id)
    {
        $chapter = Chapter::with(['photos' => function ($query) {
            $query->order('id');
        }], 'book')->cache('chapter' . $id)->find($id);
        $book_id = $chapter->book_id;
        $chapters = Cache::get('mulu'.$book_id);
        if (!$chapters){
            $chapters = Chapter::where('book_id','=',$book_id)->select();
            Cache::set('mulu'.$book_id,$chapters);
        }
        $prev = Db::query(
            'select * from chapter where book_id='.$book_id.' and id<' . $id . ' order by id desc limit 1'); //上一章
        $next = Db::query(
            'select * from chapter where book_id='.$book_id.' and id>' . $id . ' order by id limit 1'); //下一章

        if (count($prev) > 0) {
            $this->assign('prev', $prev[0]);
        } else {
            $this->assign('prev', 'null');
        }
        if (count($next) > 0) {
            $this->assign('next', $next[0]);
        } else {
            $this->assign('next', 'null');
        }
        $this->assign([
            'chapter' => $chapter,
            'chapters' => $chapters,
            'photos' => $chapter->photos
        ]);
        return view($this->tpl);
    }
}