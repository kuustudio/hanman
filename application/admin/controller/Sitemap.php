<?php
/**
 * Created by PhpStorm.
 * User: zhangxiang
 * Date: 2018/11/12
 * Time: 5:46 PM
 */

namespace app\admin\controller;


use app\model\Book;
use app\model\Chapter;

class Sitemap extends BaseAdmin
{
    public function index()
    {
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $data_array = $this->create_array();
        foreach ($data_array as $data) {
            $content .= $this->create_item($data);
        }
        $content .= '</urlset>';
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] .'/sitemap.xml', 'w+');
        fwrite($fp, $content);
        fclose($fp);
        return $this->success('生成网站地图成功','/admin','',1);
    }

    private function create_array(){
        $site_name = config('site.url');
        $data = array();
        $main = array(
            'loc' => $site_name,
            'priority' => '1.0'
        );
        $booklist= array(
            'loc' => $site_name.'/index/books/booklist.html',
            'priority' => '0.5',
            'lastmod' => date("Y-m-d"),
            'changefreq' => 'yearly'
        );

        $books = Book::all();
        foreach ($books as $key=>$book){ //这里构建所有的内容页数组
            $temp = array(
                'loc' => $site_name.'/index/books/index/id/'.$book->id.'.html',
                'priority' => '0.9',
            );
            array_push( $data,$temp);
        }

        array_push($data,$main);
        array_push($data,$booklist);
        return $data;
    }

    private function create_item($data)
    {
        $item = "<url>\n";
        $item .= "<loc>" . $data['loc'] . "</loc>\n";
        $item .= "<priority>" . $data['priority'] . "</priority>\n";
        $item .= "</url>\n";
        return $item;
    }
}