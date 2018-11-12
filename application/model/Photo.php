<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/10/5
 * Time: 11:42
 */

namespace app\model;


use think\Model;

class Photo extends Model
{
    protected $pk='id';
    protected $autoWriteTimestamp = 'datetime';

    public function chapter(){
        return $this->belongsTo('chapter');
    }
}