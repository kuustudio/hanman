<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/12/26
 * Time: 15:02
 */

namespace app\admin\controller;

use think\facade\App;
use think\Controller;
use DirectoryIterator;

class Webp extends Controller
{
    public function index(){
        $path = App::getRootPath() . 'public/static/upload/book';
        $dir = new DirectoryIterator($path);
        foreach ($dir as $dirinfo) {
            if ($dirinfo->isDir() && !$dirinfo->isDot()) {
                $book_dir = new  DirectoryIterator($dirinfo->getPathname());
                foreach ($book_dir as $book_dirinfo){
                    if ($book_dirinfo->isDir() && !$book_dirinfo->isDot()){
                        $chapter_dir = new DirectoryIterator($book_dirinfo->getPathname());
                        foreach ($chapter_dir as $fileinfo) {
                            if ($fileinfo->getExtension() == 'jpg' || $fileinfo->getExtension() == 'JPG'){
                                $this->webp($fileinfo->getPathname());
                            }
                        }
                    }
                }
            }
        }
        return 'ok';
    }

    private function webp($file){
        $im = imagecreatefromjpeg($file);
        imagewebp($im,str_replace('.jpg','.webp',$file));
        imagedestroy($im);
        dump($im);
    }
}