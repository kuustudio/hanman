<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/10/2
 * Time: 17:37
 */

namespace app\model;

use think\Model;

class Author extends Model
{
    protected $pk='id';
    protected $autoWriteTimestamp = 'datetime';

    public function books(){
        return $this->hasMany('book');
    }

    public function setAuthorNameAttr($value){
        return trim($value);
    }
}