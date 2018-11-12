<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/9/30
 * Time: 15:31
 */

namespace app\model;

use think\Model;

class Book extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = 'datetime';

    public function author()
    {
        return $this->belongsTo('Author');
    }

    public function chapters(){
        return $this->hasMany('chapter');
    }

    public function setBooknameAttr($value){
        return trim($value);
    }
}