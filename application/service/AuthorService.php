<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/10/4
 * Time: 0:02
 */

namespace app\service;


use app\model\Author;

class AuthorService
{
    public function add($name)
    {
        $author = $this->getByName($name);
        if (!$author) { //不存在该作者则新增;
            $author = new Author();
            $author->name = $name;
            $author->save();
        }
    }

    public function getByName($name){
        return Author::where('author_name','=',$name)->find();
    }

    public function getAuthors($where = '1=1'){
        $authors = Author::where($where)->with('books')->paginate(5,false,[
            'type'     => 'util\AdminPage',
            'var_page' => 'page',
        ]);
        foreach ($authors as &$author) {
            $author['count'] = count($author->books);
        }
        return [
            'authors' => $authors,
            'count' => $authors->count()
        ];
    }

    public function getBooksByAuthor($author_name){
        //return Author::where('author_name','=',$author_name)->with('books')->find();
        $books = Author::where('author_name','=',$author_name)->find()->books();
        return [
            'books' => $books->with('author')->paginate(5),
            'count' => $books->count()
        ];
    }

    public function delete($array){
        Author::destroy($array);
    }
}