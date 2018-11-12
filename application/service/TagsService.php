<?php
/**
 * Created by PhpStorm.
 * User: hiliq
 * Date: 2018/10/4
 * Time: 0:03
 */

namespace app\service;

use app\model\Tags;

class TagsService
{
    public function getByName($tagname){
        return Tags::where('tagname','=',$tagname)->find();
    }
}